<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta --}}
    <title>@hasSection('meta_title')@yield('meta_title')@else@yield('title', setting('site_name', 'SuhastraDev')) — {{ setting('site_description', 'Portfolio & Source Code Marketplace') }}@endif</title>
    <meta name="description" content="@yield('meta_description', setting('site_description', 'Website Portfolio & Marketplace Source Code oleh Indra Jasa Suhastra'))">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title', setting('site_name', 'SuhastraDev'))">
    <meta property="og:description" content="@yield('meta_description', setting('site_description', ''))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    @hasSection('og_image')
    <meta property="og:image" content="@yield('og_image')">
    @else
    @if(setting('site_og_image'))
    <meta property="og:image" content="{{ asset('storage/' . setting('site_og_image')) }}">
    @endif
    @endif

    {{-- Favicon --}}
    @if(setting('site_favicon'))
    <link rel="icon" href="{{ asset('storage/' . setting('site_favicon')) }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('storage/' . setting('site_favicon')) }}" type="image/x-icon">
    @else
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', setting('site_name', 'SuhastraDev'))">
    <meta name="twitter:description" content="@yield('meta_description', setting('site_description', ''))">
    @hasSection('og_image')
    <meta name="twitter:image" content="@yield('og_image')">
    @endif

    {{-- Robots --}}
    <meta name="robots" content="index, follow">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>

<body class="font-sans antialiased text-dark-800 bg-white">

    {{-- Navbar (persisted across SPA navigations) --}}
    @persist('navbar')
    <div x-data="appNav()" x-on:livewire:navigated.window="onNavigated()">
        <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-500"
            :class="scrolled ? 'bg-white/90 backdrop-blur-xl shadow-lg shadow-dark-900/5 border-b border-gray-100/50' : 'bg-transparent'">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 lg:h-20">

                    {{-- Logo --}}
                    <a href="{{ route('home') }}" class="flex items-center space-x-2.5 shrink-0 group">
                        <img src="{{ asset('images/logo.png') }}" alt="SuhastraDev" class="w-9 h-9 rounded-xl shadow-lg shadow-primary-600/25 group-hover:shadow-primary-600/40 transition-all duration-300 group-hover:scale-105 object-contain">
                        <span class="font-heading font-bold text-xl transition-colors duration-300"
                            :class="scrolled ? 'text-dark-900' : 'text-white'">
                            Suhastra<span class="text-primary-500">Dev</span>
                        </span>
                    </a>

                    {{-- Desktop Navigation --}}
                    <div class="hidden lg:flex items-center space-x-1">
                        @php
                        $navItems = [
                        ['route' => 'home', 'label' => __('Home')],
                        ['route' => 'about', 'label' => __('Tentang')],
                        ['route' => 'portfolio.index', 'label' => __('Portfolio')],
                        ['route' => 'products.index', 'label' => __('Produk')],
                        ['route' => 'services.index', 'label' => __('Layanan')],
                        ['route' => 'contact', 'label' => __('Kontak')],
                        ];
                        @endphp

                        @foreach ($navItems as $item)
                        @php $navPath = parse_url(route($item['route']), PHP_URL_PATH) ?: '/'; @endphp
                        <a href="{{ route($item['route']) }}" wire:navigate
                            class="relative px-4 py-2 text-sm font-medium rounded-xl transition-all duration-300"
                            :class="scrolled
                               ? (isActive('{{ $navPath }}') ? 'text-primary-600 bg-primary-50/80' : 'text-dark-600 hover:text-primary-600 hover:bg-primary-50/50')
                               : (isActive('{{ $navPath }}') ? 'text-white bg-white/15 backdrop-blur-sm' : 'text-white/80 hover:text-white hover:bg-white/10')">
                            {{ $item['label'] }}
                            <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-primary-500 rounded-full transition-all duration-300"
                                :class="isActive('{{ $navPath }}') ? 'w-5' : 'w-0'"></span>
                        </a>
                        @endforeach
                    </div>

                    {{-- Language Switcher & CTA Button --}}
                    <div class="hidden lg:flex items-center space-x-3">
                        {{-- Language Toggle --}}
                        <a href="{{ route('lang.switch', app()->getLocale() === 'id' ? 'en' : 'id') }}"
                            class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold rounded-xl transition-all duration-300 hover:-translate-y-0.5 border"
                            :class="scrolled
                               ? 'border-gray-200 text-dark-600 hover:text-primary-600 hover:border-primary-300 hover:bg-primary-50/50'
                               : 'border-white/20 text-white/80 hover:text-white hover:bg-white/10'">
                            <i class="fa-solid fa-globe text-xs"></i>
                            {{ app()->getLocale() === 'id' ? 'EN' : 'ID' }}
                        </a>

                        {{-- CTA Button --}}
                        <a href="{{ route('contact') }}" wire:navigate
                            class="inline-flex items-center px-5 py-2.5 text-sm font-semibold rounded-xl transition-all duration-300 hover:-translate-y-0.5"
                            :class="scrolled
                           ? 'bg-gradient-to-r from-primary-600 to-indigo-600 text-white hover:shadow-lg hover:shadow-primary-600/25'
                           : 'bg-white/95 text-dark-900 hover:bg-white shadow-lg'">
                            <i class="fa-solid fa-paper-plane mr-2 text-xs"></i>
                            {{ __('Hubungi Saya') }}
                        </a>
                    </div>

                    {{-- Mobile menu button --}}
                    <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 rounded-lg"
                        :class="scrolled ? 'text-dark-700 hover:bg-gray-100' : 'text-white hover:bg-white/10'">
                        <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg x-show="mobileMenu" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

        </nav>

        {{-- Mobile Sidebar Overlay --}}
        <div x-show="mobileMenu" x-cloak
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[60] bg-gray-900/50 backdrop-blur-sm lg:hidden"
            @click="mobileMenu = false">
        </div>

        {{-- Mobile Sidebar --}}
        <aside x-show="mobileMenu" x-cloak
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 z-[70] w-72 bg-white shadow-2xl lg:hidden flex flex-col">

            {{-- Sidebar Header --}}
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <a href="{{ route('home') }}" wire:navigate @click="mobileMenu = false" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo.png') }}" alt="SuhastraDev" class="w-9 h-9 rounded-lg object-contain">
                    <span class="font-heading font-bold text-xl text-dark-900">
                        Suhastra<span class="text-primary-500">Dev</span>
                    </span>
                </a>
                <button @click="mobileMenu = false" class="p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Sidebar Navigation --}}
            <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
                @php
                $sidebarIcons = [
                'home' => 'fa-solid fa-house',
                'about' => 'fa-solid fa-user',
                'portfolio.index' => 'fa-solid fa-briefcase',
                'products.index' => 'fa-solid fa-box',
                'services.index' => 'fa-solid fa-gear',
                'contact' => 'fa-solid fa-envelope',
                ];
                @endphp
                @foreach ($navItems as $item)
                @php $navPath = parse_url(route($item['route']), PHP_URL_PATH) ?: '/'; @endphp
                <a href="{{ route($item['route']) }}" wire:navigate
                    @click="mobileMenu = false"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200"
                    :class="isActive('{{ $navPath }}')
                    ? 'text-primary-700 bg-primary-50 shadow-sm'
                    : 'text-dark-600 hover:text-primary-600 hover:bg-gray-50'">
                    <i class="{{ $sidebarIcons[$item['route']] ?? 'fa-solid fa-link' }} w-5 text-center"
                        :class="isActive('{{ $navPath }}') ? 'text-primary-500' : 'text-gray-400'"></i>
                    {{ $item['label'] }}
                </a>
                @endforeach
            </nav>

            {{-- Sidebar Footer --}}
            <div class="p-4 border-t border-gray-100 space-y-3">
                {{-- Language Toggle --}}
                <a href="{{ route('lang.switch', app()->getLocale() === 'id' ? 'en' : 'id') }}"
                    class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-sm font-medium text-dark-600 bg-gray-50 rounded-xl hover:bg-primary-50 hover:text-primary-600 transition-all border border-gray-200">
                    <i class="fa-solid fa-globe text-xs"></i>
                    {{ app()->getLocale() === 'id' ? 'Switch to English' : 'Ganti ke Bahasa Indonesia' }}
                </a>
                <a href="{{ route('contact') }}" wire:navigate @click="mobileMenu = false"
                    class="flex items-center justify-center gap-2 w-full px-4 py-3 text-sm font-semibold text-white bg-primary-600 rounded-xl hover:bg-primary-700 transition-all shadow-sm">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    {{ __('Hubungi Saya') }}
                </a>
            </div>
        </aside>
    </div>
    @endpersist

    {{-- Flash Messages --}}
    @if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        x-transition:leave="transition ease-in duration-300"
        class="fixed top-20 right-4 z-[60] max-w-sm">
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 shadow-lg flex items-center space-x-3">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            <button @click="show = false" class="text-green-400 hover:text-green-600 ml-auto">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer (persisted across SPA navigations) --}}
    @persist('footer')
    <footer class="bg-dark-900 text-white relative overflow-hidden">
        {{-- Decorative gradient top border --}}
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-primary-500 to-transparent"></div>
        {{-- Background decoration --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary-600/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-indigo-600/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Top Footer --}}
            <div class="py-12 lg:py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Brand --}}
                <div class="lg:col-span-2">
                    <a href="{{ route('home') }}" wire:navigate class="flex items-center space-x-2.5 mb-4 group">
                        <img src="{{ asset('images/logo.png') }}" alt="SuhastraDev" class="w-9 h-9 rounded-xl shadow-lg shadow-primary-600/25 group-hover:shadow-primary-600/40 transition-all duration-300 group-hover:scale-105 object-contain">
                        <span class="font-heading font-bold text-xl text-white">
                            Suhastra<span class="text-primary-400">Dev</span>
                        </span>
                    </a>
                    <p class="text-dark-400 text-sm leading-relaxed max-w-md mb-6">
                        {{ setting('site_description', 'Web developer berpengalaman yang menyediakan jasa pembuatan website berkualitas dan marketplace source code siap pakai.') }}
                    </p>
                    {{-- Social Media --}}
                    <div class="flex items-center space-x-3">
                        @if (setting('contact_github'))
                        <a href="{{ setting('contact_github') }}" target="_blank" rel="noopener"
                            class="w-10 h-10 bg-dark-800 hover:bg-gradient-to-br hover:from-primary-600 hover:to-indigo-600 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-primary-600/25 hover:-translate-y-0.5">
                            <i class="fa-brands fa-github text-lg"></i>
                        </a>
                        @endif
                        @if (setting('contact_linkedin'))
                        <a href="{{ setting('contact_linkedin') }}" target="_blank" rel="noopener"
                            class="w-10 h-10 bg-dark-800 hover:bg-gradient-to-br hover:from-blue-600 hover:to-blue-700 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-blue-600/25 hover:-translate-y-0.5">
                            <i class="fa-brands fa-linkedin-in text-lg"></i>
                        </a>
                        @endif
                        @if (setting('contact_instagram'))
                        <a href="{{ setting('contact_instagram') }}" target="_blank" rel="noopener"
                            class="w-10 h-10 bg-dark-800 hover:bg-gradient-to-br hover:from-pink-600 hover:to-orange-500 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-pink-600/25 hover:-translate-y-0.5">
                            <i class="fa-brands fa-instagram text-lg"></i>
                        </a>
                        @endif
                    </div>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="font-heading font-semibold text-sm uppercase tracking-wider text-dark-400 mb-4">{{ __('Navigasi') }}</h4>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('home') }}" wire:navigate class="text-sm text-dark-300 hover:text-primary-400 transition-colors duration-200 hover:translate-x-1 inline-block">{{ __('Home') }}</a></li>
                        <li><a href="{{ route('about') }}" wire:navigate class="text-sm text-dark-300 hover:text-primary-400 transition-colors duration-200 hover:translate-x-1 inline-block">{{ __('Tentang Saya') }}</a></li>
                        <li><a href="{{ route('portfolio.index') }}" wire:navigate class="text-sm text-dark-300 hover:text-primary-400 transition-colors duration-200 hover:translate-x-1 inline-block">{{ __('Portfolio') }}</a></li>
                        <li><a href="{{ route('products.index') }}" wire:navigate class="text-sm text-dark-300 hover:text-primary-400 transition-colors duration-200 hover:translate-x-1 inline-block">{{ __('Produk') }}</a></li>
                        <li><a href="{{ route('services.index') }}" wire:navigate class="text-sm text-dark-300 hover:text-primary-400 transition-colors duration-200 hover:translate-x-1 inline-block">{{ __('Layanan') }}</a></li>
                        <li><a href="{{ route('contact') }}" wire:navigate class="text-sm text-dark-300 hover:text-primary-400 transition-colors duration-200 hover:translate-x-1 inline-block">{{ __('Kontak') }}</a></li>
                        <li><a href="{{ route('order.status') }}" wire:navigate class="text-sm text-dark-300 hover:text-primary-400 transition-colors duration-200 hover:translate-x-1 inline-block">{{ __('Cek Pesanan') }}</a></li>
                    </ul>
                </div>

                {{-- Contact Info --}}
                <div>
                    <h4 class="font-heading font-semibold text-sm uppercase tracking-wider text-dark-400 mb-4">{{ __('Kontak') }}</h4>
                    <ul class="space-y-3">
                        @if (setting('contact_email'))
                        <li class="flex items-center space-x-3 group">
                            <div class="w-8 h-8 bg-dark-800 group-hover:bg-primary-600/20 rounded-lg flex items-center justify-center transition-colors duration-300">
                                <i class="fa-solid fa-envelope text-xs text-primary-400"></i>
                            </div>
                            <a href="mailto:{{ setting('contact_email') }}" class="text-sm text-dark-300 hover:text-primary-400 transition-colors">
                                {{ setting('contact_email') }}
                            </a>
                        </li>
                        @endif
                        @if (setting('contact_whatsapp'))
                        <li class="flex items-center space-x-3 group">
                            <div class="w-8 h-8 bg-dark-800 group-hover:bg-green-600/20 rounded-lg flex items-center justify-center transition-colors duration-300">
                                <i class="fa-brands fa-whatsapp text-xs text-green-400"></i>
                            </div>
                            <a href="https://wa.me/{{ setting('contact_whatsapp') }}" target="_blank" class="text-sm text-dark-300 hover:text-green-400 transition-colors">
                                WhatsApp
                            </a>
                        </li>
                        @endif
                        @if (setting('contact_address'))
                        <li class="flex items-start space-x-3 group">
                            <div class="w-8 h-8 bg-dark-800 group-hover:bg-primary-600/20 rounded-lg flex items-center justify-center shrink-0 transition-colors duration-300">
                                <i class="fa-solid fa-location-dot text-xs text-primary-400"></i>
                            </div>
                            <span class="text-sm text-dark-300">{{ setting('contact_address') }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            {{-- Bottom Footer --}}
            <div class="border-t border-dark-800/60 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-dark-500">
                    {{ setting('footer_text', '© ' . date('Y') . ' SuhastraDev. All rights reserved.') }}
                </p>
                <p class="text-sm text-dark-500">
                    {{ __('Dibuat dengan') }} <span class="text-red-400 animate-pulse">&hearts;</span> {{ __('menggunakan Laravel & TailwindCSS') }}
                </p>
            </div>
        </div>
    </footer>
    @endpersist

    {{-- WhatsApp Floating Button --}}
    @if (setting('contact_whatsapp'))
    <div x-data="{ showTooltip: false }" class="fixed bottom-6 right-6 z-50">
        <a href="https://wa.me/{{ setting('contact_whatsapp') }}?text={{ urlencode(__('Halo, saya tertarik dengan jasa Anda.')) }}"
            target="_blank" rel="noopener"
            @mouseenter="showTooltip = true" @mouseleave="showTooltip = false"
            class="group w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-2xl shadow-lg hover:shadow-2xl hover:shadow-green-500/30 flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1">
            <i class="fa-brands fa-whatsapp text-2xl group-hover:rotate-12 transition-transform duration-300"></i>
            {{-- Ping indicator --}}
            <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-green-400 rounded-full border-2 border-white animate-pulse"></span>
        </a>
        {{-- Tooltip --}}
        <div x-show="showTooltip" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-2" x-transition:enter-end="opacity-100 translate-x-0"
            class="absolute right-16 top-1/2 -translate-y-1/2 bg-dark-900 text-white text-xs font-medium px-3 py-2 rounded-lg whitespace-nowrap shadow-lg">
            {{ __('Chat via WhatsApp') }}
            <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1 w-2 h-2 bg-dark-900 rotate-45"></div>
        </div>
    </div>
    @endif

    {{-- Navbar scroll behavior --}}
    <script>
        function appNav() {
            return {
                scrolled: false,
                mobileMenu: false,
                currentPath: window.location.pathname,
                _scrollHandler: null,

                init() {
                    this.scrolled = window.scrollY > 50;
                    this._scrollHandler = () => {
                        this.scrolled = window.scrollY > 50;
                    };
                    window.addEventListener('scroll', this._scrollHandler);
                },

                onNavigated() {
                    this.currentPath = window.location.pathname;
                    this.mobileMenu = false;
                    window.scrollTo(0, 0);
                },

                destroy() {
                    if (this._scrollHandler) window.removeEventListener('scroll', this._scrollHandler);
                },

                isActive(path) {
                    if (path === '/') return this.currentPath === '/';
                    return this.currentPath === path || this.currentPath.startsWith(path + '/');
                }
            };
        }
    </script>

    @livewireScripts
    @stack('scripts')
</body>

</html>