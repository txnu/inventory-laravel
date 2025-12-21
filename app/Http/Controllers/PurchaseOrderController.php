<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Requests\UpdatePurchaseOrderRequest;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItems;
use App\Models\Supplier;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchase_orders = PurchaseOrder::with('supplier')->get();

        return view('layouts.purchase-order.index', compact('purchase_orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = Product::all();
        $supplier = Supplier::all();

        return view('layouts.purchase-order.create', compact('supplier', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseOrderRequest $request)
    {
        $data = $request->validated();

        $po = PurchaseOrder::create([
            'po_code' => $data['po_code'],
            'supplier_id' => $data['supplier_id'],
            'order_date' => $data['order_date'],
            'delivery_date' => $data['delivery_date'],
            'status' => 'ordered',
            'notes' => $data['notes'],
            'total_amount' => $data['total_amount']
        ]);

        foreach ($data['items'] as $item) {
            PurchaseOrderItems::create([
                'po_id' => $po->po_id,
                'product_id' => $item['product_id'],
                'qty_ordered' => $item['qty_ordered'],
                'qty_received' => 0,
                'price' => $item['price'],
                'total' => $item['total'],
            ]);
        }

        return redirect()->route('purchase-order.index')
            ->with('success', 'Purchase Order created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder, $id)
    {
        $po = $purchaseOrder::with('supplier', 'items.product')
            ->where('po_id', $id)
            ->firstOrFail();

        $product = Product::all();

        $items = $po->items->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'qty_ordered' => $item->qty_ordered,
                'price'      => $item->price,
                'total'      => $item->qty_ordered * $item->price,
            ];
        });

        return view('layouts.purchase-order.show', compact('po', 'product', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder, $id)
    {
        $po = $purchaseOrder::with('supplier', 'items.product')
            ->where('po_id', $id)
            ->firstOrFail();

        $supplier = Supplier::all();
        $product = Product::all();
        $mode = request()->query('mode', 'view');

        $items = $po->items->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'qty_ordered'        => $item->qty_ordered,
                'price'      => $item->price,
                'total'      => $item->qty_ordered * $item->price,
            ];
        });


        return view('layouts.purchase-order.edit', compact('po', 'supplier', 'product', 'items', 'mode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseOrderRequest $request, PurchaseOrder $purchaseOrder, $id)
    {
        $data = $request->validated();

        $po = PurchaseOrder::findOrFail($id);

        $po->update([
            'po_code' => $data['po_code'],
            'supplier_id' => $data['supplier_id'],
            'order_date' => $data['order_date'],
            'delivery_date' => $data['delivery_date'],
            'status' => $data['status'],
            'notes' => $data['notes'],
            'total_amount' => $data['total_amount']
        ]);

        PurchaseOrderItems::where('po_id', $id)->delete();

        foreach ($data['items'] as $item) {
            PurchaseOrderItems::create([
                'po_id' => $po->po_id,
                'product_id' => $item['product_id'],
                'qty_ordered' => $item['qty_ordered'],
                'qty_received' => 0,
                'price' => $item['price'],
                'total' => $item['total'],
            ]);
        }

        $update = $purchaseOrder::where('po_id', $id)->firstOrFail();
        $update->update($data);

        return redirect()->route('purchase-order.index')->with('success', 'Purchase Order updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }
}
