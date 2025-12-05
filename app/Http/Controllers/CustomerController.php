<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer = Customer::all();

        return view('layouts.customer.index', compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();

        Customer::create([
            'customer_name' => $data['customer_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'status' => $data['status'],
        ]);

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer, $id)
    {
        $cs = $customer::where('customer_id', $id)->firstOrFail();
        $mode = request()->query('mode', 'view');

        return view('layouts.customer.modal', compact('cs', 'mode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer, $id)
    {
        $data = $request->validated();

        $update = $customer::where('customer_id', $id)->firstOrFail();
        $update->update($data);

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer, $id)
    {
        $customer::where('customer_id', $id)->delete();

        return redirect()
            ->route('customer.index')
            ->with('success', 'Customer deleted successfully');
    }
}
