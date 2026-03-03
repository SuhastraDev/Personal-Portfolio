@extends('layouts.app')

@section('title', '500 — ' . __('Terjadi Kesalahan'))

@section('content')
<section class="min-h-screen flex items-center bg-gradient-to-br from-dark-900 via-dark-800 to-primary-900">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="font-heading text-8xl font-extrabold text-amber-500 mb-4">500</p>
        <h1 class="font-heading text-3xl font-bold text-white mb-3">{{ __('Terjadi Kesalahan Server') }}</h1>
        <p class="text-dark-300 mb-8">{{ __('Maaf, terjadi kesalahan pada server kami. Silakan coba lagi nanti.') }}</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('home') }}"
                class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                {{ __('Ke Beranda') }}
            </a>
            <button onclick="window.location.reload()"
                class="inline-flex items-center px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl transition-colors backdrop-blur-sm border border-white/20">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182" />
                </svg>
                {{ __('Coba Lagi') }}
            </button>
        </div>
    </div>
</section>
@endsection