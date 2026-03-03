@extends('layouts.app')

@section('title', __('Portfolio'))
@section('meta_title', __('Portfolio'))
@section('meta_description', __('Lihat koleksi portfolio proyek web development yang telah dikerjakan oleh SuhastraDev.'))

@section('content')
{{-- Header --}}
<section class="bg-gradient-to-br from-dark-950 via-dark-900 to-primary-950 pt-32 pb-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-grid-pattern bg-grid"></div>
    </div>
    <div class="absolute top-20 right-20 w-24 h-24 border border-white/10 rounded-2xl rotate-12 animate-float hidden md:block"></div>
    <div class="absolute bottom-10 left-16 w-16 h-16 border-2 border-primary-400/20 rounded-full animate-float-slow hidden md:block"></div>
    <div class="absolute top-1/3 left-1/4 w-64 h-64 bg-primary-500/10 rounded-full blur-[80px] animate-float-reverse"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md text-primary-300 text-xs font-semibold rounded-full uppercase tracking-wider mb-5 border border-white/10" data-aos="fade-up">
                <i class="fa-solid fa-images"></i> Portfolio
            </span>
            <h1 class="font-heading text-4xl lg:text-5xl font-bold text-white mb-4" data-aos="fade-up" data-aos-delay="100">{{ __('Portfolio') }}</h1>
            <p class="text-dark-300 max-w-xl mx-auto text-lg" data-aos="fade-up" data-aos-delay="150">{{ __('Kumpulan proyek terbaik yang telah saya kerjakan untuk berbagai klien.') }}</p>
        </div>
    </div>
</section>

{{-- Portfolio Grid with Livewire Filter --}}
<section class="py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <livewire:portfolio-filter />
    </div>
</section>
@endsection