<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('order')->get();
        $testimonials = Testimonial::active()->orderBy('order')->get();
        $featuredPortfolios = Portfolio::where('is_featured', true)
            ->with('categories')
            ->latest()
            ->take(6)
            ->get();
        $services = Service::active()->orderBy('order')->take(4)->get();
        $productCount = Product::active()->count();

        return view('pages.home', compact('skills', 'testimonials', 'featuredPortfolios', 'services', 'productCount'));
    }

    public function about()
    {
        $skills = Skill::orderBy('order')->get();
        $testimonials = Testimonial::active()->orderBy('order')->get();

        return view('pages.about', compact('skills', 'testimonials'));
    }

    public function contact()
    {
        $services = Service::active()->orderBy('order')->get();

        return view('pages.contact', compact('services'));
    }
}
