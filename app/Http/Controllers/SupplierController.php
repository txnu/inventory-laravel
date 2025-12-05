<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplier = Supplier::get();
        return view('layouts.supplier.index', compact('supplier'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $data = $request->validated();

        Supplier::create([
            'supplier_name' => $data['supplier_name'],
            'contact_name' => $data['contact_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'join_at' => $data['join_at'],
            'status' => $data['status'],
        ]);

        return redirect()->route('supplier.index')->with('success', 'Supplier created');
    }

    public function edit(Supplier $supplier, $id)
    {
        $spr = $supplier::where('supplier_id', $id)->firstOrFail();
        $mode = request()->query('mode', 'view');

        return view('layouts.supplier.modal', compact('spr', 'mode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier, $id)
    {
        $data = $request->validated();

        $update = $supplier::where('supplier_id', $id)->firstOrFail();
        $update->update($data);

        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier, $id)
    {
        $supplier::where('supplier_id', $id)->delete();

        return redirect()
            ->route('supplier.index')
            ->with('success', 'Supplier deleted successfully');
    }
}
