@extends('layouts.app')

@section('title', __('Kontak'))
@section('meta_title', __('Hubungi Saya'))
@section('meta_description', __('Hubungi SuhastraDev untuk konsultasi proyek website, pembelian source code, atau kerja sama lainnya.'))

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
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur-md text-primary-300 text-xs font-semibold rounded-full uppercase tracking-wider mb-5 border border-white/10 shadow-sm" data-aos="fade-up">
                <i class="fa-solid fa-paper-plane"></i> Contact
            </span>
            <h1 class="font-heading text-4xl sm:text-5xl font-bold text-white mb-4" data-aos="fade-up" data-aos-delay="100">{{ __('Hubungi Saya') }}</h1>
            <p class="text-dark-300 max-w-xl mx-auto text-lg" data-aos="fade-up" data-aos-delay="150">{{ __('Ada pertanyaan atau proyek yang ingin didiskusikan? Jangan ragu untuk menghubungi saya.') }}</p>
        </div>
    </div>
</section>

{{-- Contact Section --}}
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Contact Info --}}
            <div data-aos="fade-right">
                <h2 class="font-heading text-2xl font-bold text-dark-900 mb-8">{{ __('Informasi Kontak') }}</h2>

                <div class="space-y-5">
                    @if (setting('contact_email'))
                    <div class="flex items-start gap-4 group p-4 bg-gray-50 hover:bg-primary-50 rounded-2xl transition-all duration-500">
                        <div class="w-12 h-12 bg-primary-100 group-hover:bg-primary-200 rounded-xl flex items-center justify-center shrink-0 transition-colors duration-300">
                            <i class="fa-solid fa-envelope text-primary-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-dark-900">{{ __('Email') }}</p>
                        </div>
                    </div>
                    @endif

                    @if (setting('contact_whatsapp'))
                    <div class="flex items-start gap-4 group p-4 bg-gray-50 hover:bg-green-50 rounded-2xl transition-all duration-500">
                        <div class="w-12 h-12 bg-green-100 group-hover:bg-green-200 rounded-xl flex items-center justify-center shrink-0 transition-colors duration-300">
                            <i class="fa-brands fa-whatsapp text-lg text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-dark-900">{{ __('WhatsApp') }}</p>
                            <a href="https://wa.me/{{ setting('contact_whatsapp') }}" target="_blank" class="text-sm text-dark-500 hover:text-green-600 transition-colors">{{ __('Chat via WhatsApp') }}</a>
                        </div>
                    </div>
                    @endif

                    @if (setting('contact_address'))
                    <div class="flex items-start gap-4 group p-4 bg-gray-50 hover:bg-primary-50 rounded-2xl transition-all duration-500">
                        <div class="w-12 h-12 bg-primary-100 group-hover:bg-primary-200 rounded-xl flex items-center justify-center shrink-0 transition-colors duration-300">
                            <i class="fa-solid fa-location-dot text-primary-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-dark-900">{{ __('Alamat') }}</p>
                            <p class="text-sm text-dark-500">{{ setting('contact_address') }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Social Media --}}
                <div class="mt-10">
                    <p class="text-sm font-semibold text-dark-900 mb-4">{{ __('Social Media') }}</p>
                    <div class="flex gap-3">
                        @if (setting('contact_github'))
                        <a href="{{ setting('contact_github') }}" target="_blank" rel="noopener" class="w-11 h-11 bg-gray-100 hover:bg-dark-900 hover:text-white text-dark-600 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg">
                            <i class="fa-brands fa-github text-lg"></i>
                        </a>
                        @endif
                        @if (setting('contact_linkedin'))
                        <a href="{{ setting('contact_linkedin') }}" target="_blank" rel="noopener" class="w-11 h-11 bg-gray-100 hover:bg-blue-700 hover:text-white text-dark-600 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg">
                            <i class="fa-brands fa-linkedin-in text-lg"></i>
                        </a>
                        @endif
                        @if (setting('contact_instagram'))
                        <a href="{{ setting('contact_instagram') }}" target="_blank" rel="noopener" class="w-11 h-11 bg-gray-100 hover:bg-pink-600 hover:text-white text-dark-600 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg">
                            <i class="fa-brands fa-instagram text-lg"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Contact Form (Livewire) --}}
            <div class="lg:col-span-2" data-aos="fade-left">
                <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-8 border border-gray-100 shadow-sm">
                    <h2 class="font-heading text-xl font-bold text-dark-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 bg-primary-50 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-message text-xs text-primary-600"></i>
                        </span>
                        {{ __('Kirim Pesan') }}
                    </h2>
                    <livewire:contact-form />
                </div>
            </div>
        </div>
    </div>
</section>
@endsection