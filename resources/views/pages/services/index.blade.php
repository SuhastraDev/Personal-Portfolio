@extends('layouts.app')

@section('title', __('Layanan'))
@section('meta_title', __('Layanan & Harga'))
@section('meta_description', __('Lihat berbagai layanan pembuatan website profesional yang ditawarkan SuhastraDev.'))

@section('content')
{{-- Header --}}
<section class="bg-gradient-to-br from-dark-950 via-dark-900 to-primary-950 pt-32 pb-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-grid-pattern bg-grid"></div>
    </div>
    <div class="absolute top-1/4 right-10 w-64 h-64 bg-primary-500/10 rounded-full blur-[80px]"></div>
    <div class="absolute bottom-0 left-10 w-48 h-48 bg-indigo-500/10 rounded-full blur-[60px]"></div>
    <div class="absolute top-20 right-20 w-20 h-20 border border-white/10 rounded-2xl rotate-12 animate-float hidden sm:block"></div>
    <div class="absolute bottom-10 left-16 w-14 h-14 border border-primary-400/20 rounded-full animate-float-slow hidden sm:block"></div>
    <div class="absolute top-1/2 left-1/3 w-8 h-8 bg-primary-400/10 rounded-lg rotate-45 animate-float-reverse hidden lg:block"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur-md text-primary-300 text-xs font-semibold rounded-full uppercase tracking-wider mb-5 border border-white/10 shadow-sm" data-aos="fade-up">
                <i class="fa-solid fa-briefcase"></i> Services
            </span>
            <h1 class="font-heading text-4xl sm:text-5xl font-bold text-white mb-4" data-aos="fade-up" data-aos-delay="100">{{ __('Layanan & Harga') }}</h1>
            <p class="text-dark-300 max-w-xl mx-auto text-lg" data-aos="fade-up" data-aos-delay="150">{{ __('Berbagai layanan pembuatan website profesional sesuai kebutuhan bisnis Anda.') }}</p>
        </div>
    </div>
</section>

{{-- Services --}}
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach ($services as $index => $service)
            <div class="bg-white rounded-2xl p-8 border border-gray-100 hover:border-primary-200 hover:shadow-2xl transition-all duration-500 group hover:-translate-y-2 relative overflow-hidden card-glow" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                {{-- Gradient accent on hover --}}
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary-500 via-purple-500 to-indigo-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                @if ($service->icon)
                <div class="w-16 h-16 bg-gradient-to-br from-primary-50 to-indigo-50 group-hover:from-primary-100 group-hover:to-indigo-100 rounded-2xl flex items-center justify-center mb-5 transition-all duration-500 group-hover:scale-110 group-hover:shadow-lg group-hover:shadow-primary-500/10">
                    <i class="{{ $service->icon }} text-2xl text-primary-600"></i>
                </div>
                @endif
                <h3 class="font-heading text-xl font-bold text-dark-900 mb-3 group-hover:text-primary-700 transition-colors">{{ $service->translated_title }}</h3>
                <div class="text-dark-600 text-sm leading-relaxed mb-5">
                    {!! nl2br(e($service->translated_description)) !!}
                </div>

                <div class="flex items-center justify-between pt-5 border-t border-gray-100">
                    <p class="font-heading text-lg font-bold text-primary-600">
                        Rp {{ number_format($service->price_start, 0, ',', '.') }}
                        @if($service->price_end)
                        — Rp {{ number_format($service->price_end, 0, ',', '.') }}
                        @else
                        ~
                        @endif
                    </p>

                    @if (setting('contact_whatsapp'))
                    @php
                    $waMsg = __("Halo, saya tertarik dengan layanan *:title*. Bisa diskusi lebih lanjut?", ['title' => $service->translated_title]);
                    @endphp
                    <a href="https://wa.me/{{ setting('contact_whatsapp') }}?text={{ urlencode($waMsg) }}"
                        target="_blank" rel="noopener"
                        class="group/btn inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-500 hover:to-indigo-500 text-white text-sm font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-primary-600/25 hover:-translate-y-0.5">
                        <i class="fa-brands fa-whatsapp mr-1.5"></i>
                        {{ __('Hubungi') }}
                        <i class="fa-solid fa-arrow-right text-xs ml-1.5 group-hover/btn:translate-x-1 transition-transform"></i>
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 lg:py-24 bg-gradient-to-br from-primary-600 via-primary-700 to-indigo-800 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-72 h-72 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full translate-x-1/3 translate-y-1/3"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-white/5 rounded-full blur-[80px]"></div>
    <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-5" data-aos="zoom-in">
            <i class="fa-solid fa-wand-magic-sparkles text-xl text-white"></i>
        </div>
        <h2 class="font-heading text-3xl lg:text-4xl font-bold text-white mb-4" data-aos="fade-up">{{ __('Butuh Layanan Custom?') }}</h2>
        <p class="text-primary-100 mb-8 text-lg" data-aos="fade-up" data-aos-delay="100">{{ __('Punya kebutuhan spesifik? Mari diskusikan proyek Anda bersama saya.') }}</p>
        <a href="{{ route('contact') }}"
            class="group inline-flex items-center px-8 py-4 bg-white text-primary-700 font-bold rounded-2xl hover:bg-gray-50 transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-1" data-aos="fade-up" data-aos-delay="200">
            <i class="fa-solid fa-paper-plane mr-2 group-hover:rotate-12 transition-transform"></i>
            {{ __('Hubungi Saya') }}
        </a>
    </div>
</section>
@endsection