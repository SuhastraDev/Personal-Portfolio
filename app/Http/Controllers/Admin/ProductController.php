<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'tags')
            ->latest()
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::orderBy('name')->get();
        $tags = ProductTag::orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'demo_url' => 'nullable|url|max:255',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'tech_stack' => 'nullable|array',
            'tech_stack.*' => 'string|max:100',
            'version' => 'nullable|string|max:50',
            'category_id' => 'required|exists:product_categories,id',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'title_en' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'features_en' => 'nullable|array',
            'features_en.*' => 'string|max:255',
            'meta_title_en' => 'nullable|string|max:255',
            'meta_description_en' => 'nullable|string|max:500',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'file_path' => 'nullable|file|mimes:zip,rar|max:102400',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:product_tags,id',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active');

        // Process thumbnail
        $image = Image::read($request->file('thumbnail'));
        $image->cover(800, 600);
        $thumbPath = 'products/' . uniqid() . '.webp';
        Storage::disk('public')->put($thumbPath, $image->toWebp(85));
        $validated['thumbnail'] = $thumbPath;

        // Upload product file
        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->store('products/files', 'local');
        }

        $product = Product::create(collect($validated)->except(['tags', 'images'])->toArray());

        if (!empty($validated['tags'])) {
            $product->tags()->attach($validated['tags']);
        }

        // Process additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $img = Image::read($file);
                $img->scaleDown(1200);
                $imgPath = 'products/' . uniqid() . '.webp';
                Storage::disk('public')->put($imgPath, $img->toWebp(85));

                $product->images()->create([
                    'image_path' => $imgPath,
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $product->load('tags', 'images');
        $categories = ProductCategory::orderBy('name')->get();
        $tags = ProductTag::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'tags'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'demo_url' => 'nullable|url|max:255',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'tech_stack' => 'nullable|array',
            'tech_stack.*' => 'string|max:100',
            'version' => 'nullable|string|max:50',
            'category_id' => 'required|exists:product_categories,id',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'title_en' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'features_en' => 'nullable|array',
            'features_en.*' => 'string|max:255',
            'meta_title_en' => 'nullable|string|max:255',
            'meta_description_en' => 'nullable|string|max:500',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'file_path' => 'nullable|file|mimes:zip,rar|max:102400',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:product_tags,id',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active');

        // Process new thumbnail
        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($product->thumbnail);

            $image = Image::read($request->file('thumbnail'));
            $image->cover(800, 600);
            $thumbPath = 'products/' . uniqid() . '.webp';
            Storage::disk('public')->put($thumbPath, $image->toWebp(85));
            $validated['thumbnail'] = $thumbPath;
        }

        // Upload new product file
        if ($request->hasFile('file_path')) {
            if ($product->file_path) {
                Storage::disk('local')->delete($product->file_path);
            }
            $validated['file_path'] = $request->file('file_path')->store('products/files', 'local');
        }

        $product->update(collect($validated)->except(['tags', 'images'])->toArray());
        $product->tags()->sync($validated['tags'] ?? []);

        // Process additional images
        if ($request->hasFile('images')) {
            $baseOrder = $product->images()->count();
            foreach ($request->file('images') as $index => $file) {
                $img = Image::read($file);
                $img->scaleDown(1200);
                $imgPath = 'products/' . uniqid() . '.webp';
                Storage::disk('public')->put($imgPath, $img->toWebp(85));

                $product->images()->create([
                    'image_path' => $imgPath,
                    'order' => $baseOrder + $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        Storage::disk('public')->delete($product->thumbnail);

        if ($product->file_path) {
            Storage::disk('local')->delete($product->file_path);
        }

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->tags()->detach();
        $product->images()->delete();
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function destroyImage(Product $product, ProductImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}
