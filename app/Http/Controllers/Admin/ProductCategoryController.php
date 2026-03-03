<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::withCount('products')->orderBy('name')->paginate(15);
        return view('admin.product-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.product-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name',
            'slug' => 'nullable|string|max:255|unique:product_categories,slug',
            'name_en' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);

        ProductCategory::create($validated);

        return redirect()->route('admin.product-categories.index')->with('success', 'Kategori produk berhasil ditambahkan.');
    }

    public function edit(ProductCategory $productCategory)
    {
        return view('admin.product-categories.edit', compact('productCategory'));
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name,' . $productCategory->id,
            'slug' => 'nullable|string|max:255|unique:product_categories,slug,' . $productCategory->id,
            'name_en' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);

        $productCategory->update($validated);

        return redirect()->route('admin.product-categories.index')->with('success', 'Kategori produk berhasil diperbarui.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        if ($productCategory->products()->count() > 0) {
            return back()->with('error', 'Kategori ini tidak bisa dihapus karena masih memiliki produk terkait.');
        }

        $productCategory->delete();

        return redirect()->route('admin.product-categories.index')->with('success', 'Kategori produk berhasil dihapus.');
    }
}
