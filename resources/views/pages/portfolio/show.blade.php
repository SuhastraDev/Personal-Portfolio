@extends('layouts.app')

@section('title', $portfolio->translated_title)
@section('meta_title', $portfolio->translated_meta_title ?: $portfolio->translated_title)
@section('meta_description', $portfolio->translated_meta_description ?: Str::limit(strip_tags($portfolio->translated_description), 160))

@if($portfolio->thumbnail)
@section('og_image', asset('storage/' . $portfolio->thumbnail))
@endif

@section('content')
{{-- Header --}}
<section class="bg-gradient-to-br from-dark-950 via-dark-900 to-primary-950 pt-32 pb-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-grid-pattern bg-grid"></div>
    </div>
    <div class="absolute top-1/4 right-10 w-64 h-64 bg-primary-500/10 rounded-full blur-[80px]"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-sm text-dark-400 mb-6" data-aos="fade-up">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors duration-200">{{ __('Home') }}</a>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
            <a href="{{ route('portfolio.index') }}" class="hover:text-white transition-colors duration-200">{{ __('Portfolio') }}</a>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
            <span class="text-white font-medium">{{ $portfolio->translated_title }}</span>
        </nav>
        <h1 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-5" data-aos="fade-up" data-aos-delay="100">{{ $portfolio->translated_title }}</h1>
        <div class="flex flex-wrap gap-2" data-aos="fade-up" data-aos-delay="150">
            @foreach ($portfolio->categories as $cat)
            <span class="px-3 py-1.5 text-xs font-semibold bg-white/10 backdrop-blur-sm text-white rounded-full border border-white/10">{{ $cat->translated_name }}</span>
            @endforeach
        </div>
    </div>
</section>

{{-- Detail --}}
<section class="py-16 lg:py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Thumbnail --}}
        @if ($portfolio->thumbnail)
        <div class="rounded-2xl overflow-hidden shadow-2xl mb-12 img-zoom" data-aos="fade-up">
            <img src="{{ asset('storage/' . $portfolio->thumbnail) }}" alt="{{ $portfolio->translated_title }}" class="w-full">
        </div>
        @endif

        {{-- Meta Info --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-12" data-aos="fade-up" data-aos-delay="100">
            @if ($portfolio->client_name)
            <div class="bg-gradient-to-br from-gray-50 to-primary-50/30 rounded-2xl p-5 border border-gray-100 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center mb-2">
                    <i class="fa-solid fa-user text-xs text-primary-600"></i>
                </div>
                <p class="text-xs text-dark-400 mb-1 font-medium uppercase tracking-wider">{{ __('Klien') }}</p>
                <p class="text-sm font-bold text-dark-800">{{ $portfolio->client_name }}</p>
            </div>
            @endif
            @if ($portfolio->completion_date)
            <div class="bg-gradient-to-br from-gray-50 to-indigo-50/30 rounded-2xl p-5 border border-gray-100 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mb-2">
                    <i class="fa-solid fa-calendar text-xs text-indigo-600"></i>
                </div>
                <p class="text-xs text-dark-400 mb-1 font-medium uppercase tracking-wider">{{ __('Selesai') }}</p>
                <p class="text-sm font-bold text-dark-800">{{ $portfolio->completion_date->format('M Y') }}</p>
            </div>
            @endif
            @if (!empty($portfolio->tech_stack))
            <div class="bg-gradient-to-br from-gray-50 to-purple-50/30 rounded-2xl p-5 border border-gray-100 col-span-2 hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mb-2">
                    <i class="fa-solid fa-layer-group text-xs text-purple-600"></i>
                </div>
                <p class="text-xs text-dark-400 mb-2 font-medium uppercase tracking-wider">Tech Stack</p>
                <div class="flex flex-wrap gap-1.5">
                    @foreach ($portfolio->tech_stack as $tech)
                    <span class="px-2.5 py-1 text-xs font-medium bg-primary-50 text-primary-700 rounded-lg">{{ $tech }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Description --}}
        <div class="prose prose-lg max-w-none text-dark-700 mb-12" data-aos="fade-up">
            {!! nl2br(e($portfolio->translated_description)) !!}
        </div>

        {{-- Project URL --}}
        @if ($portfolio->url)
        <div class="mb-12" data-aos="fade-up">
            <a href="{{ $portfolio->url }}" target="_blank" rel="noopener"
                class="group inline-flex items-center px-7 py-3.5 bg-gradient-to-r from-primary-600 to-indigo-600 text-white font-semibold rounded-2xl hover:from-primary-500 hover:to-indigo-500 transition-all duration-300 shadow-lg shadow-primary-600/25 hover:shadow-xl hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
                {{ __('Lihat Proyek') }}
                <i class="fa-solid fa-arrow-right ml-2 text-sm opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i>
            </a>
        </div>
        @endif

        {{-- Gallery --}}
        @if ($portfolio->images->count() > 0)
        <div class="mb-12">
            <h3 class="font-heading text-xl font-bold text-dark-900 mb-6 flex items-center gap-2" data-aos="fade-up">
                <span class="w-8 h-8 bg-primary-50 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-camera text-xs text-primary-600"></i>
                </span>
                {{ __('Screenshot') }}
            </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($portfolio->images as $index => $image)
                    <div class="rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 img-zoom" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                            alt="{{ $portfolio->translated_title }} screenshot"
                            class="w-full"
                            loading="lazy">
                    </div>
                    @endforeach
                </div>
        </div>
        @endif
    </div>
</section>

{{-- Related --}}
@if ($relatedPortfolios->count() > 0)
<section class="py-16 lg:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="font-heading text-2xl font-bold text-dark-900 mb-8" data-aos="fade-up">{{ __('Portfolio Terkait') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($relatedPortfolios as $index => $related)
            <a href="{{ route('portfolio.show', $related->slug) }}" class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-primary-200 transition-all duration-500 hover:-translate-y-2 card-glow" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="aspect-video bg-gray-100 overflow-hidden relative">
                    @if ($related->thumbnail)
                    <img src="{{ asset('storage/' . $related->thumbnail) }}" alt="{{ $related->translated_title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-dark-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
                <div class="p-5">
                    <h4 class="font-heading font-bold text-dark-900 group-hover:text-primary-600 transition-colors duration-300">{{ $related->translated_title }}</h4>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
