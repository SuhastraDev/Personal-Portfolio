<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PortfolioCategoryController extends Controller
{
    public function index()
    {
        $categories = PortfolioCategory::withCount('portfolios')->orderBy('name')->paginate(15);
        return view('admin.portfolio-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.portfolio-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:portfolio_categories,name',
            'slug' => 'nullable|string|max:255|unique:portfolio_categories,slug',
            'name_en' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);

        PortfolioCategory::create($validated);

        return redirect()->route('admin.portfolio-categories.index')->with('success', 'Kategori portfolio berhasil ditambahkan.');
    }

    public function edit(PortfolioCategory $portfolioCategory)
    {
        return view('admin.portfolio-categories.edit', compact('portfolioCategory'));
    }

    public function update(Request $request, PortfolioCategory $portfolioCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:portfolio_categories,name,' . $portfolioCategory->id,
            'slug' => 'nullable|string|max:255|unique:portfolio_categories,slug,' . $portfolioCategory->id,
            'name_en' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);

        $portfolioCategory->update($validated);

        return redirect()->route('admin.portfolio-categories.index')->with('success', 'Kategori portfolio berhasil diperbarui.');
    }

    public function destroy(PortfolioCategory $portfolioCategory)
    {
        if ($portfolioCategory->portfolios()->count() > 0) {
            return back()->with('error', 'Kategori ini tidak bisa dihapus karena masih memiliki portfolio terkait.');
        }

        $portfolioCategory->delete();

        return redirect()->route('admin.portfolio-categories.index')->with('success', 'Kategori portfolio berhasil dihapus.');
    }
}
