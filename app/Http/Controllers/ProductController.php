<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();

        return view('layouts.products.index', compact('products'));
    }

    public function detail($id)
    {
        $product = Product::with('category')->where('product_id', $id)->firstOrFail();
        $categories = Category::all();
        $mode = request()->query('mode', 'view');

        return view('layouts.products.modal', compact('product', 'categories', 'mode'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,category_id',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'is_active' => 'boolean'
        ]);

        $product = Product::where('product_id', $id)->firstOrFail();

        $product->update($request->all());

        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }

    public function delete($id)
    {
        $product = Product::where('product_id', $id)->firstOrFail();
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product has been deleted successfully');
    }
}
