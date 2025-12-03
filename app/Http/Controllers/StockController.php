<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stock = Stock::with('product')->get();
        return view('layouts.stock.index', compact('stock'));
    }
}
