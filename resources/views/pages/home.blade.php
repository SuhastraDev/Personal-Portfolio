@extends('layouts.app')

@section('title', 'SuhastraDev')
@section('meta_title', 'Portfolio & Source Code Marketplace')

@section('content')
{{-- Hero Section --}}
<section class="relative min-h-screen flex items-center bg-gradient-to-br from-dark-950 via-dark-900 to-primary-950 overflow-hidden">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-grid-pattern bg-grid"></div>
    </div>

    {{-- Animated Gradient Orbs --}}
    <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-primary-500/20 rounded-full blur-[100px] animate-float-slow"></div>
    <div class="absolute bottom-1/4 right-1/4 w-[400px] h-[400px] bg-indigo-500/20 rounded-full blur-[100px] animate-float-reverse"></div>
    <div class="absolute top-1/2 right-1/3 w-72 h-72 bg-purple-500/10 rounded-full blur-[80px] animate-float"></div>

    {{-- Floating Geometric Shapes --}}
    <div class="absolute top-20 right-20 w-24 h-24 border border-white/10 rounded-2xl rotate-12 animate-float hidden md:block"></div>
    <div class="absolute bottom-32 left-16 w-16 h-16 border-2 border-primary-400/20 rounded-full animate-float-slow hidden md:block"></div>
    <div class="absolute top-1/3 right-1/4 w-3 h-3 bg-primary-400/60 rounded-full animate-ping hidden md:block" style="animation-duration: 2s;"></div>
    <div class="absolute bottom-1/3 left-1/3 w-2 h-2 bg-indigo-400/60 rounded-full animate-ping hidden md:block" style="animation-duration: 3s;"></div>
    <div class="absolute top-1/2 left-10 w-20 h-20 border border-indigo-400/10 rounded-xl animate-rotate-slow hidden lg:block"></div>
    <div class="absolute bottom-20 right-1/3 w-4 h-4 bg-primary-300/30 rounded-full animate-float-reverse hidden md:block"></div>

    {{-- Morphing blob --}}
    <div class="absolute top-1/4 right-10 w-64 h-64 bg-gradient-to-br from-primary-500/10 to-indigo-500/10 animate-morph hidden lg:block"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md rounded-full border border-white/10 mb-8 shadow-lg shadow-primary-500/5" data-aos="fade-up" data-aos-duration="600">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-400"></span>
                </span>
                <span class="text-primary-300 font-medium text-sm">{{ setting('hero_subtitle', 'Available for Projects') }}</span>
            </div>
            <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-[1.1] mb-6" data-aos="fade-up" data-aos-delay="100" data-aos-duration="700">
                {{ setting('hero_title', 'Indra Jasa Suhastra') }}
                <span class="block mt-3" x-data="{ texts: ['Full-Stack Developer', 'Laravel Expert', 'UI/UX Enthusiast'], current: 0, show: true }" x-init="setInterval(() => { show = false; setTimeout(() => { current = (current + 1) % texts.length; show = true; }, 300); }, 3000)">
                    <span x-text="texts[current]" x-show="show"
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 translate-y-4 blur-sm"
                        x-transition:enter-end="opacity-100 translate-y-0 blur-none"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0 -translate-y-4 blur-sm"
                        class="text-2xl sm:text-3xl lg:text-4xl text-transparent bg-clip-text bg-gradient-to-r from-primary-400 via-indigo-400 to-purple-400 animate-text-glow">Full-Stack Developer</span>
                </span>
            </h1>
            <p class="text-lg sm:text-xl text-dark-300 leading-relaxed mb-10 max-w-2xl" data-aos="fade-up" data-aos-delay="200" data-aos-duration="700">
                {{ setting('hero_description', 'Web developer berpengalaman yang menyediakan jasa pembuatan website berkualitas dan marketplace source code siap pakai untuk kebutuhan bisnis Anda.') }}
            </p>
            <div class="flex flex-wrap gap-4" data-aos="fade-up" data-aos-delay="300" data-aos-duration="700">
                <a href="{{ route('portfolio.index') }}" wire:navigate
                    class="group inline-flex items-center px-7 py-4 bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-500 hover:to-indigo-500 text-white font-semibold rounded-2xl transition-all duration-300 shadow-xl shadow-primary-600/25 hover:shadow-2xl hover:shadow-primary-600/40 hover:-translate-y-1">
                    <i class="fa-solid fa-images mr-2.5 group-hover:scale-110 transition-transform duration-300"></i>
                    {{ setting('hero_cta_text', 'Lihat Portfolio') }}
                    <i class="fa-solid fa-arrow-right ml-2 text-sm opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i>
                </a>
                <a href="{{ route('contact') }}" wire:navigate
                    class="group inline-flex items-center px-7 py-4 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-2xl transition-all duration-300 backdrop-blur-md border border-white/20 hover:border-white/30 hover:-translate-y-1 hover:shadow-lg">
                    <i class="fa-solid fa-paper-plane mr-2.5 group-hover:rotate-12 transition-transform duration-300"></i>
                    {{ __('Hubungi Saya') }}
                </a>}
                <div class="mt-12 flex flex-wrap items-center gap-3" data-aos="fade-up" data-aos-delay="400" data-aos-duration="700">
                    <span class="text-dark-500 text-xs uppercase tracking-wider font-medium">{{ __('Tech:') }}</span>
                    @php $techIcons = ['fa-brands fa-laravel' => 'Laravel', 'fa-brands fa-vuejs' => 'Vue.js', 'fa-brands fa-php' => 'PHP', 'fa-brands fa-js' => 'JavaScript']; @endphp
                    @foreach ($techIcons as $icon => $name)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg text-xs text-dark-300 hover:bg-white/10 hover:text-white transition-all duration-300 hover:-translate-y-0.5 cursor-default">
                        <i class="{{ $icon }} text-sm"></i> {{ $name }}
                    </span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2" data-aos="fade-up" data-aos-delay="600">
            <span class="text-white/30 text-[10px] uppercase tracking-[0.2em] font-medium">{{ __('Scroll') }}</span>
            <div class="w-6 h-10 border-2 border-white/20 rounded-full flex justify-center pt-2">
                <div class="w-1 h-2.5 bg-white/50 rounded-full animate-bounce"></div>
            </div>
        </div>
</section>

{{-- Stats --}}
<section class="py-14 bg-white border-b border-gray-100 relative">
    <div class="absolute inset-0 bg-gradient-to-r from-primary-50/30 via-transparent to-indigo-50/30"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            <div class="text-center group" data-aos="fade-up" x-data="counter({{ setting('about_experience_years', '3') }})" x-intersect.once="start()">
                <div class="w-14 h-14 bg-primary-50 group-hover:bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-3 transition-all duration-500 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-primary-200/50 group-hover:-translate-y-1">
                    <i class="fa-solid fa-calendar-check text-xl text-primary-600"></i>
                </div>
                <p class="font-heading text-3xl font-bold text-primary-600"><span x-text="display"></span>+</p>
                <p class="text-sm text-dark-500 mt-1 font-medium">{{ __('Tahun Pengalaman') }}</p>
            </div>
            <div class="text-center group" data-aos="fade-up" data-aos-delay="80" x-data="counter({{ setting('about_projects_count', '50') }})" x-intersect.once="start()">
                <div class="w-14 h-14 bg-indigo-50 group-hover:bg-indigo-100 rounded-2xl flex items-center justify-center mx-auto mb-3 transition-all duration-500 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-indigo-200/50 group-hover:-translate-y-1">
                    <i class="fa-solid fa-diagram-project text-xl text-indigo-600"></i>
                </div>
                <p class="font-heading text-3xl font-bold text-primary-600"><span x-text="display"></span>+</p>
                <p class="text-sm text-dark-500 mt-1 font-medium">{{ __('Proyek Selesai') }}</p>
            </div>
            <div class="text-center group" data-aos="fade-up" data-aos-delay="160" x-data="counter({{ setting('about_clients_count', '30') }})" x-intersect.once="start()">
                <div class="w-14 h-14 bg-green-50 group-hover:bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-3 transition-all duration-500 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-green-200/50 group-hover:-translate-y-1">
                    <i class="fa-solid fa-users text-xl text-green-600"></i>
                </div>
                <p class="font-heading text-3xl font-bold text-primary-600"><span x-text="display"></span>+</p>
                <p class="text-sm text-dark-500 mt-1 font-medium">{{ __('Klien Puas') }}</p>
            </div>
            <div class="text-center group" data-aos="fade-up" data-aos-delay="240" x-data="counter({{ $productCount }})" x-intersect.once="start()">
                <div class="w-14 h-14 bg-amber-50 group-hover:bg-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-3 transition-all duration-500 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-amber-200/50 group-hover:-translate-y-1">
                    <i class="fa-solid fa-code text-xl text-amber-600"></i>
                </div>
                <p class="font-heading text-3xl font-bold text-primary-600"><span x-text="display"></span></p>
                <p class="text-sm text-dark-500 mt-1 font-medium">{{ __('Source Code') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- Skills --}}
<section class="py-20 lg:py-28 bg-gray-50 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-72 h-72 bg-primary-100/30 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-100/20 rounded-full blur-3xl translate-x-1/3 translate-y-1/3"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-aos="fade-up">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary-50 text-primary-600 text-xs font-semibold rounded-full uppercase tracking-wider mb-4 shadow-sm">
                <i class="fa-solid fa-wand-magic-sparkles"></i> Tech Stack
            </span>
            <h2 class="font-heading text-3xl lg:text-4xl font-bold text-dark-900 mb-3">{{ __('Teknologi & Skill') }}</h2>
            <p class="text-dark-500 max-w-2xl mx-auto">{{ __('Teknologi yang saya kuasai untuk membangun solusi digital berkualitas.') }}</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($skills as $index => $skill)
            <div class="bg-white rounded-2xl p-5 text-center border border-gray-100 hover:border-primary-200 transition-all duration-500 group hover:-translate-y-2 card-glow" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                @if ($skill->icon)
                <div class="w-14 h-14 bg-gradient-to-br from-primary-50 to-indigo-50 group-hover:from-primary-100 group-hover:to-indigo-100 rounded-2xl flex items-center justify-center mx-auto mb-3 transition-all duration-500 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-primary-200/50 group-hover:rotate-6">
                    <i class="{{ $skill->icon }} text-2xl text-primary-600 group-hover:text-primary-700 transition-colors duration-300"></i>
                </div>
                @endif
                <p class="font-semibold text-dark-800 text-sm group-hover:text-primary-700 transition-colors duration-300">{{ $skill->name }}</p>
                <div class="mt-3 w-full bg-gray-100 rounded-full h-1.5 overflow-hidden" x-data="{ width: 0 }" x-intersect.once="setTimeout(() => width = {{ $skill->level }}, 200)">
                    <div class="bg-gradient-to-r from-primary-500 to-indigo-500 h-1.5 rounded-full transition-all duration-1000 ease-out" :style="'width: ' + width + '%'"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Portfolio --}}
@if ($featuredPortfolios->count() > 0)
<section class="py-20 lg:py-28 bg-white relative overflow-hidden">
    <div class="absolute top-1/2 right-0 w-96 h-96 bg-primary-50/50 rounded-full blur-3xl translate-x-1/2 -translate-y-1/2"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-14" data-aos="fade-up">
            <div>
                <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary-50 text-primary-600 text-xs font-semibold rounded-full uppercase tracking-wider mb-4 shadow-sm">
                    <i class="fa-solid fa-star"></i> Portfolio
                </span>
                <h2 class="font-heading text-3xl lg:text-4xl font-bold text-dark-900 mb-3">{{ __('Portfolio Unggulan') }}</h2>
                <p class="text-dark-500 max-w-xl">{{ __('Beberapa proyek terbaik yang telah saya kerjakan.') }}</p>
            </div>
            <a href="{{ route('portfolio.index') }}" wire:navigate class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-primary-600 hover:text-white bg-primary-50 hover:bg-primary-600 rounded-xl transition-all duration-300 group">
                {{ __('Lihat Semua') }}
                <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($featuredPortfolios as $index => $portfolio)
            <a href="{{ route('portfolio.show', $portfolio->slug) }}" wire:navigate
                class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-primary-200 transition-all duration-500 hover:-translate-y-2 card-glow"
                data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="aspect-video bg-gray-100 overflow-hidden relative">
                    @if ($portfolio->thumbnail)
                    <img src="{{ asset('storage/' . $portfolio->thumbnail) }}"
                        alt="{{ $portfolio->translated_title }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out"
                        loading="lazy">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-50 flex items-center justify-center">
                        <i class="fa-solid fa-image text-4xl text-primary-300"></i>
                    </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-dark-900/80 via-dark-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end p-5">
                        <span class="text-white text-sm font-medium flex items-center gap-2 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <span class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                            </span>
                            {{ __('Lihat Detail') }}
                        </span>
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex flex-wrap gap-1.5 mb-3">
                        @foreach ($portfolio->categories as $cat)
                        <span class="px-2.5 py-0.5 text-xs font-medium bg-primary-50 text-primary-700 rounded-full">{{ $cat->translated_name }}</span>
                        @endforeach
                    </div>
                    <h3 class="font-heading font-bold text-dark-900 group-hover:text-primary-600 transition-colors duration-300">{{ $portfolio->translated_title }}</h3>
                    <p class="text-sm text-dark-500 mt-1.5 line-clamp-2">{{ Str::limit(strip_tags($portfolio->translated_description), 100) }}</p>
                </div>
            </a>
            @endforeach
        </div>
        <div class="text-center mt-10 sm:hidden">
            <a href="{{ route('portfolio.index') }}" wire:navigate class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold text-primary-600 bg-primary-50 rounded-xl hover:bg-primary-100 transition-colors">
                {{ __('Lihat Semua Portfolio') }}
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- Services --}}
@if ($services->count() > 0)
<section class="py-20 lg:py-28 bg-gray-50 relative overflow-hidden">
    <div class="absolute top-0 left-1/4 w-72 h-72 bg-primary-100/30 rounded-full blur-3xl -translate-y-1/2"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-aos="fade-up">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary-50 text-primary-600 text-xs font-semibold rounded-full uppercase tracking-wider mb-4 shadow-sm">
                <i class="fa-solid fa-briefcase"></i> Services
            </span>
            <h2 class="font-heading text-3xl lg:text-4xl font-bold text-dark-900 mb-3">{{ __('Layanan') }}</h2>
            <p class="text-dark-500 max-w-2xl mx-auto">{{ __('Solusi digital yang saya tawarkan untuk bisnis Anda.') }}</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($services as $index => $service)
            <div class="bg-white rounded-2xl p-6 border border-gray-100 hover:border-primary-200 transition-all duration-500 group hover:-translate-y-2 card-glow relative overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary-500 via-indigo-500 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 origin-left"></div>
                @if ($service->icon)
                <div class="w-14 h-14 bg-gradient-to-br from-primary-50 to-indigo-50 group-hover:from-primary-100 group-hover:to-indigo-100 rounded-2xl flex items-center justify-center mb-4 transition-all duration-500 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-primary-200/50 group-hover:rotate-3">
                    <i class="{{ $service->icon }} text-2xl text-primary-600"></i>
                </div>
                @endif
                <h3 class="font-heading font-bold text-dark-900 mb-2 group-hover:text-primary-700 transition-colors duration-300">{{ $service->translated_title }}</h3>
                <p class="text-sm text-dark-500 mb-4 line-clamp-3">{{ Str::limit(strip_tags($service->translated_description), 120) }}</p>
                <p class="text-sm font-bold text-primary-600">
                    Rp {{ number_format($service->price_start, 0, ',', '.') }}
                    @if($service->price_end)
                    — Rp {{ number_format($service->price_end, 0, ',', '.') }}
                    @else
                    ~
                    @endif
                </p>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-10">
            <a href="{{ route('services.index') }}" wire:navigate class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold text-primary-600 bg-primary-50 hover:bg-primary-100 rounded-xl transition-all duration-300 group hover:-translate-y-0.5">
                {{ __('Lihat Semua Layanan') }}
                <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- Testimonials --}}
@if ($testimonials->count() > 0)
<section class="py-20 lg:py-28 bg-white relative overflow-hidden">
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary-50/40 rounded-full blur-3xl -translate-x-1/2 translate-y-1/2"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-aos="fade-up">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary-50 text-primary-600 text-xs font-semibold rounded-full uppercase tracking-wider mb-4 shadow-sm">
                <i class="fa-solid fa-quote-left"></i> Testimonials
            </span>
            <h2 class="font-heading text-3xl lg:text-4xl font-bold text-dark-900 mb-3">{{ __('Apa Kata Klien') }}</h2>
            <p class="text-dark-500 max-w-2xl mx-auto">{{ __('Testimoni dari klien yang telah bekerja sama dengan saya.') }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($testimonials as $index => $testimonial)
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-6 border border-gray-100 hover:border-primary-100 transition-all duration-500 hover:-translate-y-2 card-glow relative group" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="absolute top-5 right-5 w-10 h-10 bg-primary-50 group-hover:bg-primary-100 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:scale-110">
                    <i class="fa-solid fa-quote-right text-primary-300 group-hover:text-primary-400 transition-colors"></i>
                </div>
                <div class="flex gap-0.5 mb-4">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa-solid fa-star text-sm {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-gray-200' }}"></i>
                        @endfor
                </div>
                <p class="text-sm text-dark-600 leading-relaxed mb-5">"{{ $testimonial->content }}"</p>
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    @if($testimonial->avatar)
                    <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->client_name }}" class="w-11 h-11 rounded-full object-cover ring-2 ring-primary-100">
                    @else
                    <div class="w-11 h-11 bg-gradient-to-br from-primary-500 to-indigo-600 rounded-full flex items-center justify-center shadow-md shadow-primary-500/20">
                        <span class="text-sm font-bold text-white">{{ substr($testimonial->client_name, 0, 1) }}</span>
                    </div>
                    @endif
                    <div>
                        <p class="text-sm font-bold text-dark-900">{{ $testimonial->client_name }}</p>
                        @if($testimonial->client_role)
                        <p class="text-xs text-dark-500">{{ $testimonial->client_role }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="py-20 lg:py-28 bg-gradient-to-br from-primary-600 via-primary-700 to-indigo-800 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-80 h-80 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-white/5 rounded-full translate-x-1/3 translate-y-1/3"></div>
    <div class="absolute top-1/2 left-1/4 w-2 h-2 bg-white/20 rounded-full animate-ping" style="animation-duration: 2s;"></div>
    <div class="absolute top-1/3 right-1/4 w-3 h-3 bg-white/10 rounded-full animate-ping" style="animation-duration: 3s;"></div>
    <div class="absolute top-20 right-20 w-20 h-20 border border-white/10 rounded-2xl animate-float hidden md:block"></div>
    <div class="absolute bottom-1/4 left-10 w-16 h-16 border border-white/5 rounded-full animate-float-reverse hidden md:block"></div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="w-16 h-16 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-8 animate-float" data-aos="zoom-in">
            <i class="fa-solid fa-rocket text-2xl text-white"></i>
        </div>
        <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-5" data-aos="fade-up">{{ __('Punya Proyek Menarik?') }}</h2>
        <p class="text-primary-100 text-lg mb-10 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            {{ __('Mari diskusikan bagaimana saya bisa membantu mewujudkan ide digital Anda menjadi kenyataan.') }}
        </p>
        <div class="flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('contact') }}" wire:navigate
                class="group inline-flex items-center px-8 py-4 bg-white text-primary-700 font-bold rounded-2xl hover:bg-gray-50 transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-1">
                <i class="fa-solid fa-paper-plane mr-2.5 group-hover:rotate-12 transition-transform duration-300"></i>
                {{ __('Mulai Diskusi') }}
            </a>
            <a href="{{ route('products.index') }}" wire:navigate
                class="group inline-flex items-center px-8 py-4 bg-white/10 text-white font-bold rounded-2xl hover:bg-white/20 transition-all duration-300 backdrop-blur-sm border border-white/20 hover:-translate-y-1 hover:shadow-lg">
                <i class="fa-solid fa-cart-shopping mr-2.5 group-hover:scale-110 transition-transform duration-300"></i>
                {{ __('Jelajahi Source Code') }}
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function counter(target) {
        return {
            current: 0,
            target: target,
            display: '0',
            start() {
                const duration = 2000;
                const steps = 60;
                const increment = this.target / steps;
                const stepTime = duration / steps;
                const interval = setInterval(() => {
                    this.current += increment;
                    if (this.current >= this.target) {
                        this.current = this.target;
                        clearInterval(interval);
                    }
                    this.display = Math.floor(this.current).toString();
                }, stepTime);
            }
        };
    }
</script>
@endpush
@endsection