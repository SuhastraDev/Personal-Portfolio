<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;

class PortfolioController extends Controller
{
    public function index()
    {
        $categories = PortfolioCategory::orderBy('name')->get();

        return view('pages.portfolio.index', compact('categories'));
    }

    public function show(Portfolio $portfolio)
    {
        $portfolio->load('categories', 'images');

        $relatedPortfolios = Portfolio::where('id', '!=', $portfolio->id)
            ->whereHas('categories', function ($q) use ($portfolio) {
                $q->whereIn('portfolio_categories.id', $portfolio->categories->pluck('id'));
            })
            ->with('categories')
            ->take(3)
            ->get();

        return view('pages.portfolio.show', compact('portfolio', 'relatedPortfolios'));
    }
}
