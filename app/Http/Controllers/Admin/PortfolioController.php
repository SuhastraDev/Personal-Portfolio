<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PortfolioImage;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::with('categories')
            ->latest()
            ->paginate(15);

        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        $categories = PortfolioCategory::orderBy('name')->get();
        return view('admin.portfolios.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:portfolios,slug',
            'description' => 'required|string',
            'client_name' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'tech_stack' => 'nullable|array',
            'tech_stack.*' => 'string|max:100',
            'completion_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'title_en' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'meta_title_en' => 'nullable|string|max:255',
            'meta_description_en' => 'nullable|string|max:500',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:portfolio_categories,id',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');

        // Process thumbnail
        $image = Image::read($request->file('thumbnail'));
        $image->cover(800, 600);
        $thumbPath = 'portfolios/' . uniqid() . '.webp';
        Storage::disk('public')->put($thumbPath, $image->toWebp(85));
        $validated['thumbnail'] = $thumbPath;

        $portfolio = Portfolio::create(collect($validated)->except(['categories', 'images'])->toArray());
        $portfolio->categories()->attach($validated['categories']);

        // Process additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $img = Image::read($file);
                $img->scaleDown(1200);
                $imgPath = 'portfolios/' . uniqid() . '.webp';
                Storage::disk('public')->put($imgPath, $img->toWebp(85));

                $portfolio->images()->create([
                    'image_path' => $imgPath,
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio berhasil ditambahkan.');
    }

    public function edit(Portfolio $portfolio)
    {
        $portfolio->load('categories', 'images');
        $categories = PortfolioCategory::orderBy('name')->get();

        return view('admin.portfolios.edit', compact('portfolio', 'categories'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:portfolios,slug,' . $portfolio->id,
            'description' => 'required|string',
            'client_name' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'tech_stack' => 'nullable|array',
            'tech_stack.*' => 'string|max:100',
            'completion_date' => 'nullable|date',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'title_en' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'meta_title_en' => 'nullable|string|max:255',
            'meta_description_en' => 'nullable|string|max:500',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:portfolio_categories,id',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');

        // Process new thumbnail
        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($portfolio->thumbnail);

            $image = Image::read($request->file('thumbnail'));
            $image->cover(800, 600);
            $thumbPath = 'portfolios/' . uniqid() . '.webp';
            Storage::disk('public')->put($thumbPath, $image->toWebp(85));
            $validated['thumbnail'] = $thumbPath;
        }

        $portfolio->update(collect($validated)->except(['categories', 'images'])->toArray());
        $portfolio->categories()->sync($validated['categories']);

        // Process additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $img = Image::read($file);
                $img->scaleDown(1200);
                $imgPath = 'portfolios/' . uniqid() . '.webp';
                Storage::disk('public')->put($imgPath, $img->toWebp(85));

                $portfolio->images()->create([
                    'image_path' => $imgPath,
                    'order' => $portfolio->images()->count() + $index,
                ]);
            }
        }

        return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio berhasil diperbarui.');
    }

    public function destroy(Portfolio $portfolio)
    {
        // Delete thumbnail
        Storage::disk('public')->delete($portfolio->thumbnail);

        // Delete all images
        foreach ($portfolio->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $portfolio->categories()->detach();
        $portfolio->images()->delete();
        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio berhasil dihapus.');
    }

    /**
     * Delete a single portfolio image via AJAX.
     */
    public function destroyImage(Portfolio $portfolio, PortfolioImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}
