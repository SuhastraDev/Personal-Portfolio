<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTag;

class ProductController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::orderBy('name')->get();
        $tags = ProductTag::orderBy('name')->get();

        return view('pages.products.index', compact('categories', 'tags'));
    }

    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        $product->load('category', 'tags', 'images');

        $relatedProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->with('category')
            ->take(4)
            ->get();

        return view('pages.products.show', compact('product', 'relatedProducts'));
    }
}
