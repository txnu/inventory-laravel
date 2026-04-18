<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseReceivingRequest;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItems;
use Illuminate\Http\Request;
use App\Models\PurchaseReceiving;
use App\Models\PurchaseReceivingItems;
use App\Models\Stock;
use App\Models\StockAdjustment;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PurchaseReceivingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchase_receivings = PurchaseReceiving::with(['user'])->get();

        return view('layouts.purchase-receiving.index', compact('purchase_receivings'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function get_po($po_id)
    {
        $purchase_order = PurchaseOrder::with('supplier', 'items.product')
            ->where('po_id', $po_id)
            ->first();

        if (!$purchase_order) {
            return response()->json([
                'status' => false,
                'message' => 'PO not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'po' => $purchase_order
        ]);
    }


    public function create()
    {
        $purchase_orders = PurchaseOrder::whereIn('status', ['ordered', 'partial'])
            ->get();

        $users = User::all();

        $receiving_code = $this->generate_receiving_code();

        return view('layouts.purchase-receiving.create', compact('purchase_orders', 'users', 'receiving_code'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseReceivingRequest $request)
    {
        $data = $request->validated();
        $receiving_code = $this->generate_receiving_code();

        // STORE

        DB::beginTransaction();

        try {
            $receiving = PurchaseReceiving::create([
                'po_id' => $data['po_id'],
                'receiving_code' => $receiving_code,
                'receiving_date' => $data['receiving_date'],
                'status' => 'partial',
                'receiving_by' => $data['supplier_id'],
            ]);

            foreach ($data['items'] as $item) {
                $receive_now = intval($item['qty_received_now']);
                if ($receive_now <= 0) continue;

                $po_item = PurchaseOrderItems::where('po_item_id', $item['po_item_id'])
                    ->where('po_id', $data['po_id'])
                    ->firstOrFail();



                $remaining_qty = $po_item->qty_ordered - $po_item->qty_received;
                $receive_now = min($receive_now, $remaining_qty);
                if ($receive_now <= 0) continue;

                $stock = Stock::where('product_id', $po_item->product_id)->first();

                // CREATE PURCHASE RECEIVING ITEMS
                PurchaseReceivingItems::create([
                    'pr_id' => $receiving->pr_id,
                    'product_id' => $po_item->product_id,
                    'qty_received' => $receive_now,
                    'note' => $item['note'] ?? null
                ]);

                // UPDATE QTY RECEIVED IN PURCHASE ORDER ITEMS
                $po_item->qty_received += $receive_now;
                $po_item->save();

                // CALCULATE STOCK ADJUSTMENT
                $systemQty = $stock->qty_on_hand;
                $physicalQty = $systemQty + $receive_now;
                $difference = $physicalQty - $systemQty;

                // CREATE STOCK ADJUSTMENT
                $stock_adjusment = StockAdjustment::create([
                    'product_id' => $po_item->product_id,
                    'product_stock_id' => $stock->stock_id,
                    'system_qty' => $systemQty ?? null,
                    'physical_qty' => $physicalQty ?? null,
                    'difference' => $difference ?? null,
                    'reason' => $data['reason'] ?? null,
                    'performed_by' => 1,
                ]);

                $movementType = $difference >= 0 ? 'IN' : 'OUT';

                $movementQty = abs($difference);

                // CREATE STOCK MOVEMENT
                StockMovement::create(
                    [
                        'product_id' => $po_item->product_id,
                        'product_stock_id' => $stock->stock_id,
                        'movement_type' => $movementType,
                        'reference_type' => 'PURCHASE_RECEIVING',
                        'reference_id' => $stock_adjusment->stock_a_id,
                        'qty' => $movementQty,
                        'before_qty' => $systemQty,
                        'after_qty' => $physicalQty,
                        'created_by' => 1,
                    ]
                );

                // VALIDATED STOCK
                if ($stock) {
                    $stock->qty_on_hand += $receive_now;
                    $stock->save();
                } else {
                    Stock::create([
                        'product_id' => $po_item->product_id,
                        'qty' => $receive_now,
                    ]);
                }
            }



            // UPDATE STATUS PURCHASE ORDER
            $all_po_items = PurchaseOrderItems::where('po_id', $data['po_id'])->get();
            $is_completed = $all_po_items->every(function ($item) {
                return $item->qty_received >= $item->qty_ordered;
            });

            $total_received = $all_po_items->sum('qty_received');
            $total_ordered = $all_po_items->sum('qty_ordered');

            if ($total_received == 0) {
                $status = 'ordered';
            } elseif ($total_received < $total_ordered) {
                $status = 'partial';
            } else {
                $status = 'received';
            }

            // Status for receiving
            $receiving_status = ($total_received >= $total_ordered) ? 'completed' : 'partial';


            $po = PurchaseOrder::find($data['po_id']);
            $po->status = $status;
            $po->save();

            // Update status for receiving
            $receiving->status = $receiving_status;
            $receiving->save();


            DB::commit();

            return redirect()->route('purchase-receiving.index')
                ->with('success', 'Receiving saved successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseReceiving $purchase_receiving, $id)
    {
        $pr = $purchase_receiving::with('items.product')
            ->where('pr_id', $id)
            ->firstOrFail();

        $product = Product::all();

        $items = $pr->items->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'qty_received' => $item->qty_received,
                'note'      => $item->note,
            ];
        });

        return view('layouts.purchase-receiving.show', compact('pr', 'product', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function generate_receiving_code()
    {
        //GET LAST PRODUCT
        $get_receiving_code = PurchaseReceiving::where('receiving_code', 'like', 'PR%')
            ->orderBy('receiving_code', 'desc')
            ->first();

        if (!$get_receiving_code) {
            return 'PR001';
        }

        //GET LAST NUMBER OF PRODUCT

        $last_number = (int) substr($get_receiving_code->receiving_code, 3);
        $new_number = $last_number + 1;

        return 'PR' . str_pad($new_number, 3, '0', STR_PAD_LEFT);
    }
}
