<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index()
    {
        $stock_movement = StockMovement::with(['product', 'stock', 'user'])->get();
        return view('layouts.stock-movement.index', compact('stock_movement'));
    }
}
