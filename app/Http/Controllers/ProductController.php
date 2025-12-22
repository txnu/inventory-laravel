<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Stock;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();

        return view('layouts.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('layouts.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sku' => 'required|string|max:50|uppercase|unique:products,sku',
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,category_id',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'barcode' => 'required|numeric',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ], [
            'selling_price.gte' => 'Selling price must be greater than or equal to purchase price.',
            'barcode.unique' => 'This barcode already exists.',
            'sku.unique' => 'This SKU already exists.'
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('products', 'public');
        }

        $product = Product::create([
            'sku' => $request->sku,
            'product_name' => $request->product_name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'barcode' => $request->barcode,
            'image_url' => $imagePath,
            'is_active' => $request->is_active ?? 1,

        ]);


        Stock::create([
            'product_id' => $product->product_id,
            'qty_on_hand' => 0,
            'qty_reserved' => 0
        ]);

        return redirect()->route('product.index')->with('success', 'Product added successfully');
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
