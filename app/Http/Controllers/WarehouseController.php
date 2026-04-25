<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouse = Warehouse::get();
        return view('layouts.warehouse.index', compact('warehouse'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wr_code = $this->generate_warehouse_code();
        return view('layouts.warehouse.create', compact('wr_code'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWarehouseRequest $request)
    {
        $data = $request->validated();

        Warehouse::create([
            'warehouse_code' => $data['warehouse_code'],
            'warehouse_name' => $data['warehouse_name'],
            'description' => $data['description'],
            'country' => $data['country'],
            'province' => $data['province'],
            'city' => $data['city'],
            'postal_code' => $data['postal_code'],
            'address' => $data['address'],
            'is_active' => $data['is_active']
        ]);

        return redirect()->route('warehouse.index')->with('success', 'Warehouse updated successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse, $id)
    {
        $w = $warehouse::where('warehouse_id', $id)->firstOrFail();
        $mode = request()->query('mode', 'view');

        return view('layouts.warehouse.modal', compact('w', 'mode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse, $id)
    {
        $w = $warehouse::where('warehouse_id', $id)->firstOrFail();
        $mode = request()->query('mode', 'view');

        return view('layouts.warehouse.modal', compact('w', 'mode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse, $id)
    {
        $data = $request->validated();

        $update = $warehouse::where('warehouse_id', $id)->firstOrFail();
        $update->update($data);

        return redirect()->route('warehouse.index')->with('success', 'Warehouse updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        $delete = $warehouse::where('warehouse_id', $warehouse->warehouse_id)->firstOrFail();
        $delete->delete();

        return redirect()->route('warehouse.index')->with('success', 'Warehouse deleted successfully');
    }

    private function generate_warehouse_code()
    {
        $lastWarehouse = Warehouse::orderBy('created_at', 'desc')->first();

        if (!$lastWarehouse) {
            return 'WH0001';
        }

        $lastCode = $lastWarehouse->warehouse_code;
        $number = (int) substr($lastCode, 3);
        $number++;
        return 'WH' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
