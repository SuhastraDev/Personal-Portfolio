<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductTagController extends Controller
{
    public function index()
    {
        $tags = ProductTag::withCount('products')->orderBy('name')->paginate(15);
        return view('admin.product-tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.product-tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_tags,name',
            'slug' => 'nullable|string|max:255|unique:product_tags,slug',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);

        ProductTag::create($validated);

        return redirect()->route('admin.product-tags.index')->with('success', 'Tag berhasil ditambahkan.');
    }

    public function edit(ProductTag $productTag)
    {
        return view('admin.product-tags.edit', compact('productTag'));
    }

    public function update(Request $request, ProductTag $productTag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_tags,name,' . $productTag->id,
            'slug' => 'nullable|string|max:255|unique:product_tags,slug,' . $productTag->id,
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);

        $productTag->update($validated);

        return redirect()->route('admin.product-tags.index')->with('success', 'Tag berhasil diperbarui.');
    }

    public function destroy(ProductTag $productTag)
    {
        if ($productTag->products()->count() > 0) {
            return back()->with('error', 'Tag ini tidak bisa dihapus karena masih memiliki produk terkait.');
        }

        $productTag->delete();

        return redirect()->route('admin.product-tags.index')->with('success', 'Tag berhasil dihapus.');
    }
}
