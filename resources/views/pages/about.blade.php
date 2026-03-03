@extends('layouts.app')

@section('title', __('Tentang Saya'))
@section('meta_title', __('Tentang Saya') . ' — Indra Jasa Suhastra')
@section('meta_description', setting('about_bio', 'Web developer berpengalaman yang siap membantu membangun solusi digital berkualitas.'))

@section('content')
{{-- Header --}}
<section class="bg-gradient-to-br from-dark-950 via-dark-900 to-primary-950 pt-32 pb-20 relative overflow-hidden">
    {{-- Decorative elements --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-grid-pattern bg-grid"></div>
    </div>
    <div class="absolute top-20 right-20 w-24 h-24 border border-white/10 rounded-2xl rotate-12 animate-float hidden md:block"></div>
    <div class="absolute bottom-10 left-16 w-16 h-16 border-2 border-primary-400/20 rounded-full animate-float-slow hidden md:block"></div>
    <div class="absolute top-1/2 left-1/4 w-3 h-3 bg-primary-400/40 rounded-full animate-ping hidden md:block" style="animation-duration: 2s;"></div>
    <div class="absolute top-1/4 right-1/3 w-64 h-64 bg-primary-500/10 rounded-full blur-[80px] animate-float-reverse"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md text-primary-300 text-xs font-semibold rounded-full uppercase tracking-wider mb-5 border border-white/10" data-aos="fade-up">
                <i class="fa-solid fa-user"></i> About Me
            </span>
            <h1 class="font-heading text-4xl lg:text-5xl font-bold text-white mb-4" data-aos="fade-up" data-aos-delay="100">{{ __('Tentang Saya') }}</h1>
            <p class="text-dark-300 max-w-xl mx-auto text-lg" data-aos="fade-up" data-aos-delay="150">{{ __('Mengenal lebih dekat siapa di balik SuhastraDev.') }}</p>
        </div>
    </div>
</section>

{{-- About Content --}}
<section class="py-20 lg:py-28 bg-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary-50/40 rounded-full blur-3xl translate-x-1/2 -translate-y-1/2"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            {{-- Photo --}}
            <div class="flex justify-center" data-aos="fade-right" data-aos-duration="800">
                <div class="relative">
                    @if (setting('about_photo'))
                    <img src="{{ asset('storage/' . setting('about_photo')) }}"
                        alt="{{ setting('about_name', 'Indra Jasa Suhastra') }}"
                        class="w-80 h-80 rounded-3xl object-cover shadow-2xl relative z-10 border-4 border-white">
                    @else
                    <div class="w-80 h-80 bg-gradient-to-br from-primary-100 to-indigo-100 rounded-3xl flex items-center justify-center relative z-10 shadow-2xl border-4 border-white">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-primary-500 to-indigo-600 rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-lg">
                                <span class="font-heading text-4xl font-bold text-white">S</span>
                            </div>
                            <p class="font-heading font-semibold text-primary-700">SuhastraDev</p>
                        </div>
                    </div>
                    @endif
                    {{-- Decorative frame --}}
                    <div class="absolute -bottom-4 -right-4 w-80 h-80 border-2 border-primary-200/60 rounded-3xl z-0"></div>
                    <div class="absolute -top-4 -left-4 w-24 h-24 bg-gradient-to-br from-primary-50 to-indigo-50 rounded-2xl z-0 flex items-center justify-center shadow-lg animate-float">
                        <i class="fa-solid fa-code text-2xl text-primary-500"></i>
                    </div>
                    {{-- Additional decoration --}}
                    <div class="absolute -bottom-8 -left-8 w-16 h-16 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl z-0 flex items-center justify-center shadow-md animate-float-reverse">
                        <i class="fa-solid fa-palette text-lg text-indigo-500"></i>
                    </div>
                    {{-- Glow effect --}}
                    <div class="absolute inset-0 w-80 h-80 bg-primary-400/20 rounded-3xl blur-2xl z-0 group-hover:bg-primary-400/30 transition-colors"></div>
                </div>
            </div>

            {{-- Bio --}}
            <div data-aos="fade-left" data-aos-duration="800">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary-50 text-primary-600 text-xs font-semibold rounded-full uppercase tracking-wider mb-5 shadow-sm">
                    <i class="fa-solid fa-heart"></i> {{ __('Passion') }}
                </span>
                <h2 class="font-heading text-3xl lg:text-4xl font-bold text-dark-900 mb-3">
                    {{ setting('about_name', 'Indra Jasa Suhastra') }}
                </h2>
                <p class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-indigo-600 font-bold text-lg mb-6">Full-Stack Web Developer</p>
                <div class="prose prose-sm text-dark-600 leading-relaxed mb-8">
                    <p>{{ setting('about_bio', 'Saya adalah seorang web developer berpengalaman yang fokus membangun solusi digital berkualitas menggunakan teknologi modern seperti Laravel, React, dan TailwindCSS.') }}</p>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center bg-gradient-to-br from-white to-primary-50/50 rounded-2xl p-5 border border-gray-100 hover:shadow-xl transition-all duration-500 hover:-translate-y-1 group card-glow">
                        <div class="w-10 h-10 bg-primary-100 group-hover:bg-primary-200 rounded-xl flex items-center justify-center mx-auto mb-2 transition-all duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-calendar-check text-primary-600"></i>
                        </div>
                        <p class="font-heading text-2xl font-bold text-primary-600">{{ setting('about_experience_years', '3') }}+</p>
                        <p class="text-xs text-dark-500 mt-1 font-medium">{{ __('Tahun Pengalaman') }}</p>
                    </div>
                    <div class="text-center bg-gradient-to-br from-white to-indigo-50/50 rounded-2xl p-5 border border-gray-100 hover:shadow-xl transition-all duration-500 hover:-translate-y-1 group card-glow">
                        <div class="w-10 h-10 bg-indigo-100 group-hover:bg-indigo-200 rounded-xl flex items-center justify-center mx-auto mb-2 transition-all duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-diagram-project text-indigo-600"></i>
                        </div>
                        <p class="font-heading text-2xl font-bold text-primary-600">{{ setting('about_projects_count', '50') }}+</p>
                        <p class="text-xs text-dark-500 mt-1 font-medium">{{ __('Proyek Selesai') }}</p>
                    </div>
                    <div class="text-center bg-gradient-to-br from-white to-green-50/50 rounded-2xl p-5 border border-gray-100 hover:shadow-xl transition-all duration-500 hover:-translate-y-1 group card-glow">
                        <div class="w-10 h-10 bg-green-100 group-hover:bg-green-200 rounded-xl flex items-center justify-center mx-auto mb-2 transition-all duration-300 group-hover:scale-110">
                            <i class="fa-solid fa-users text-green-600"></i>
                        </div>
                        <p class="font-heading text-2xl font-bold text-primary-600">{{ setting('about_clients_count', '30') }}+</p>
                        <p class="text-xs text-dark-500 mt-1 font-medium">{{ __('Klien Puas') }}</p>
                    </div>
                </div>
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
            <p class="text-dark-500">{{ __('Teknologi yang saya kuasai dan gunakan sehari-hari.') }}</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 max-w-4xl mx-auto">
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
                <p class="text-xs text-dark-400 mt-1.5 font-medium">{{ $skill->level }}%</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Testimonials --}}
@if ($testimonials->count() > 0)
<section class="py-20 lg:py-28 bg-white relative overflow-hidden">
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary-50/40 rounded-full blur-3xl -translate-x-1/2 translate-y-1/2"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14" data-aos="fade-up">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary-50 text-primary-600 text-xs font-semibold rounded-full uppercase tracking-wider mb-4 shadow-sm">
                <i class="fa-solid fa-quote-left"></i> Testimonials
            </span>
            <h2 class="font-heading text-3xl lg:text-4xl font-bold text-dark-900 mb-3">{{ __('Testimoni Klien') }}</h2>
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
@endsection