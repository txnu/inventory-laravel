<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesOrderController extends Controller
{
    public function index()
    {
        return view('layouts.sales-order.index');
    }
}
