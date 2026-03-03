@extends('layouts.app')

@section('title', '404 — ' . __('Halaman Tidak Ditemukan'))

@section('content')
<section class="min-h-screen flex items-center bg-gradient-to-br from-dark-900 via-dark-800 to-primary-900">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="font-heading text-8xl font-extrabold text-primary-500 mb-4">404</p>
        <h1 class="font-heading text-3xl font-bold text-white mb-3">{{ __('Halaman Tidak Ditemukan') }}</h1>
        <p class="text-dark-300 mb-8">{{ __('Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan.') }}</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('home') }}"
                class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                {{ __('Ke Beranda') }}
            </a>
            <a href="{{ route('contact') }}"
                class="inline-flex items-center px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl transition-colors backdrop-blur-sm border border-white/20">
                {{ __('Hubungi Kami') }}
            </a>
        </div>
    </div>
</section>
@endsection