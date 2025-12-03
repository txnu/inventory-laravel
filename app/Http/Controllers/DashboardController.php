<?php

namespace App\Http\Controllers;

use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $product_count = Product::count();
        return view('dashboard', compact('product_count'));
    }
}
