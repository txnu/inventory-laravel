<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseReceivingRequest;
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

        return view('layouts.purchase-receiving.create', compact('purchase_orders', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseReceivingRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $receiving = PurchaseReceiving::create([
                'po_id' => $data['po_id'],
                'receiving_code' => $data['receiving_code'],
                'receiving_date' => $data['receiving_date'],
                'status' => 'PARTIAL',
                'receiving_by' => $data['supplier_id'],
                'qty_received' => $data['qty_received'],
            ]);

            foreach ($data['items'] as $item) {
                $receive_now = intval($item['qty_received_now']);
                if ($receive_now <= 0) continue;

                $po_item = PurchaseOrderItems::where('po_item_id', $item['po_item_id'])
                    ->where('po_id', $data['po_id'])
                    ->firstOrFail();

                $stock = Stock::where('product_id', $po_item->product_id)->first();


                PurchaseReceivingItems::create([
                    'pr_id' => $receiving->pr_id,
                    'product_id' => $po_item->product_id,
                    'qty_received' => $receive_now,
                    'note' => $item['note'] ?? null
                ]);

                $po_item->qty_received += $receive_now;
                $po_item->save();

                $systemQty = $stock->qty_on_hand;
                $physicalQty = $systemQty + $receive_now;
                $difference = $physicalQty - $systemQty;

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

            $all_po_items = PurchaseOrderItems::where('po_id', $data['po_id'])->get();

            $is_completed = $all_po_items->every(function ($item) {
                return $item->qty_received >= $item->qty_ordered;
            });

            $po = PurchaseOrder::find($data['po_id']);
            $po->status = $is_completed ? 'completed' : 'partial';
            $po->save();

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
    public function show(string $id)
    {
        //
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
}
