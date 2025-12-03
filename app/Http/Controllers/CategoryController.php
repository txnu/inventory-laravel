<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('layouts.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('layouts.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'category_name' => $request->category_name,
            'description' => $request->description,
        ]);

        return redirect()->route('category.index')->with('success', 'Category added successfully');
    }

    public function detail($id)
    {
        $category = Category::where('category_id', $id)->firstOrFail();
        $mode = request()->query('mode', 'view');

        return view('layouts.categories.modal', compact('category', 'mode'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::where('category_id', $id)->firstOrFail();

        $category->update($request->all());

        return redirect()->route('category.index')->with('success', 'Category updated successfully');
    }

    public function delete($id)
    {
        $product = Category::where('category_id', $id)->firstOrFail();
        $product->delete();

        return redirect()->route('category.index')->with('success', 'Category has been deleted successfully');
    }
}
