<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockAdjustmentRequest;
use App\Http\Requests\UpdateStockAdjustmentRequest;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockAdjustment;
use App\Models\StockMovement;

class StockAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stock_adjustment = StockAdjustment::with('product', 'performedBy')->get();
        return view('layouts.stock-adjustment.index', compact('stock_adjustment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = Product::where('is_active', 1)->get();
        return view('layouts.stock-adjustment.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockAdjustmentRequest $request)
    {
        $data = $request->validated();

        $stock = Stock::where('product_id', $data['product_id'])->firstOrFail();

        $systemQty = $stock->qty_on_hand;
        $physicalQty = $data['physical_qty'];
        $difference = $physicalQty - $systemQty;

        $stock_adjusment = StockAdjustment::create([
            'product_id' => $data['product_id'],
            'product_stock_id' => $stock->stock_id,
            'system_qty' => $systemQty ?? null,
            'physical_qty' => $physicalQty ?? null,
            'difference' => $difference ?? null,
            'reason' => $data['reason'] ?? null,
            'performed_by' => 1,
        ]);

        $movementType = $difference >= 0 ? 'IN' : 'OUT';

        $movementQty = abs($difference);


        StockMovement::create([
            'product_id' => $data['product_id'],
            'product_stock_id' => $stock->stock_id,
            'movement_type' => $movementType,
            'reference_type' => 'ADJUSTMENT_STOCK',
            'reference_id' => $stock_adjusment->stock_a_id,
            'qty' => $movementQty,
            'before_qty' => $systemQty,
            'after_qty' => $physicalQty,
            'created_by' => 1,
        ]);

        $stock->update([
            'qty_on_hand' => $physicalQty
        ]);

        return redirect()->back()->with('success', 'Stock adjustment created');
    }

    /**
     * Display the specified resource.
     */
    public function show(StockAdjustment $stockAdjustment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockAdjustment $stockAdjustment)
    {
        $supplier = $stockAdjustment::get();

        return view('layouts.stock-adjustment.modal', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockAdjustmentRequest $request, StockAdjustment $stockAdjustment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockAdjustment $stockAdjustment)
    {
        //
    }
}
