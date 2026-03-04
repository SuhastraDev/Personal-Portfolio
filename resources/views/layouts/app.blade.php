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
    @elseif(setting('site_og_image'))
    <meta property="og:image" content="{{ asset('storage/' . setting('site_og_image')) }}">
    @endif

    {{-- Favicon --}}
    @if(setting('site_favicon'))
    <link rel="icon" href="{{ asset('storage/' . setting('site_favicon')) }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('storage/' . setting('site_favicon')) }}" type="image/x-icon">
    @else
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', setting('site_name', 'SuhastraDev'))">
    <meta name="twitter:description" content="@yield('meta_description', setting('site_description', ''))">
    @hasSection('og_image')
    <meta name="twitter:image" content="@yield('og_image')">
    @endif
    <meta name="robots" content="index, follow">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        /* ── Page transition (only works with wire:navigate) ── */
        main#main-content {
            opacity: 1;
            transform: translateY(0);
        }

        main#main-content.page-leaving {
            opacity: 0;
            transform: translateY(-6px);
            transition: opacity 100ms ease-in, transform 100ms ease-in;
        }

        main#main-content.page-entering {
            opacity: 0;
            transform: translateY(8px);
        }

        main#main-content.page-entering-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 250ms cubic-bezier(0, 0, .2, 1),
                transform 250ms cubic-bezier(0, 0, .2, 1);
        }

        /* ── Mobile sidebar ── */
        .sidebar-link {
            position: relative;
            transition: padding-left .22s cubic-bezier(.34, 1.56, .64, 1),
                color .2s ease, background .2s ease;
        }

        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 14%;
            bottom: 14%;
            width: 3px;
            border-radius: 0 3px 3px 0;
            background: linear-gradient(180deg, #6366f1, #8b5cf6);
            transform: scaleY(0);
            transform-origin: center;
            transition: transform .25s cubic-bezier(.34, 1.56, .64, 1);
        }

        .sidebar-link.is-active {
            padding-left: 1.35rem;
        }

        .sidebar-link.is-active::before {
            transform: scaleY(1);
        }

        .sidebar-link:not(.is-active):hover {
            padding-left: 1.35rem;
        }

        /* ── WhatsApp pulse ── */
        @keyframes wa-ring {
            0% { transform: scale(1); opacity: .6; }
            100% { transform: scale(1.9); opacity: 0; }
        }

        .wa-ring {
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: rgba(34, 197, 94, .3);
            animation: wa-ring 2.4s ease-out infinite;
        }
    </style>

    @stack('styles')
</head>

<body class="font-sans antialiased bg-white text-gray-800 overflow-x-hidden selection:bg-indigo-100 selection:text-indigo-800">

    {{-- ╔══════════════════════════════╗
         ║  NAVBAR  (@persist)          ║
         ╚══════════════════════════════╝ --}}
    @persist('navbar')
    <div x-data="appNav()">

        <nav class="fixed top-0 inset-x-0 z-50 transition-all duration-500 ease-out"
            :class="scrolled
                ? 'bg-white/80 backdrop-blur-2xl shadow-[0_2px_32px_rgba(99,102,241,.07)] border-b border-gray-100/60'
                : 'bg-dark-950/95 backdrop-blur-xl'">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 lg:h-[70px]">

                    {{-- Logo --}}
                    <a href="{{ route('home') }}" wire:navigate
                        class="flex items-center gap-2.5 shrink-0 group rounded-xl">
                        <div class="relative">
                            <div class="absolute inset-0 rounded-xl bg-indigo-400/20 blur-md opacity-0 group-hover:opacity-100 scale-110 transition-opacity duration-300 pointer-events-none"></div>
                            <img src="{{ asset('images/logo.png') }}" alt="SuhastraDev"
                                class="relative w-9 h-9 rounded-xl object-contain transition-transform duration-300 group-hover:scale-105">
                        </div>
                        <span class="font-heading font-bold text-[1.1rem] leading-none transition-colors duration-300"
                            :class="scrolled ? 'text-gray-900' : 'text-white'">
                            Suhastra<span class="text-indigo-400">Dev</span>
                        </span>
                    </a>

                    {{-- Desktop Links --}}
                    <div class="hidden lg:flex items-center gap-0.5">
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
                        @php $path = parse_url(route($item['route']), PHP_URL_PATH) ?: '/'; @endphp
                        <a href="{{ route($item['route']) }}" wire:navigate
                            class="relative px-4 py-2.5 text-[.84rem] font-medium rounded-xl transition-all duration-300"
                            :class="scrolled
                                   ? (isActive('{{ $path }}') ? 'text-indigo-600 bg-indigo-50/90' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50/60')
                                   : (isActive('{{ $path }}') ? 'text-white bg-white/15'           : 'text-white/75 hover:text-white hover:bg-white/10')">
                            {{ $item['label'] }}
                            <span class="absolute bottom-1.5 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-indigo-500 transition-all duration-300"
                                :class="isActive('{{ $path }}') ? 'opacity-100 scale-100' : 'opacity-0 scale-0'">
                            </span>
                        </a>
                        @endforeach
                    </div>

                    {{-- Desktop Actions --}}
                    <div class="hidden lg:flex items-center gap-2.5">
                        {{-- Lang — TANPA wire:navigate, butuh full reload untuk ganti session --}}
                        <a href="{{ route('lang.switch', app()->getLocale() === 'id' ? 'en' : 'id') }}"
                            class="inline-flex items-center gap-1.5 px-3 py-2 text-[.75rem] font-semibold rounded-xl border transition-all duration-300 hover:-translate-y-0.5 active:scale-95"
                            :class="scrolled
                               ? 'bg-gray-50/60 border-gray-200/80 text-gray-600 hover:text-indigo-600 hover:border-indigo-300/60 hover:bg-indigo-50/50'
                               : 'border-white/20 text-white/75 hover:text-white hover:bg-white/10'">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                            </svg>
                            {{ app()->getLocale() === 'id' ? 'EN' : 'ID' }}
                        </a>

                        {{-- CTA --}}
                        <a href="{{ route('contact') }}" wire:navigate
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-xl transition-all duration-300 hover:-translate-y-0.5 active:scale-95"
                            :class="scrolled
                               ? 'bg-gradient-to-br from-indigo-600 to-violet-600 text-white shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/35 hover:from-indigo-500 hover:to-violet-500'
                               : 'bg-white/95 text-gray-900 shadow-lg shadow-black/10 hover:bg-white hover:shadow-black/20'">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z" />
                            </svg>
                            {{ __('Hubungi Saya') }}
                        </a>
                    </div>

                    {{-- Hamburger --}}
                    <button @click="mobileMenu = !mobileMenu"
                        class="lg:hidden p-2.5 rounded-xl transition-all active:scale-90"
                        :class="scrolled ? 'text-gray-700 hover:bg-gray-100' : 'text-white hover:bg-white/10'"
                        aria-label="Toggle menu">
                        <div class="w-5 flex flex-col gap-[5px]">
                            <span class="block h-[1.5px] rounded-full bg-current transition-all duration-300 origin-center"
                                :class="mobileMenu ? 'rotate-45 translate-y-[7px]' : ''"></span>
                            <span class="block h-[1.5px] rounded-full bg-current transition-all duration-300"
                                :class="mobileMenu ? 'opacity-0 scale-x-0' : ''"></span>
                            <span class="block h-[1.5px] rounded-full bg-current transition-all duration-300 origin-center"
                                :class="mobileMenu ? '-rotate-45 -translate-y-[7px]' : ''"></span>
                        </div>
                    </button>
                </div>
            </div>
        </nav>

        {{-- Mobile Overlay --}}
        <div x-show="mobileMenu" x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="mobileMenu = false"
            class="fixed inset-0 z-[60] bg-gray-950/45 backdrop-blur-sm lg:hidden">
        </div>

        {{-- Mobile Sidebar --}}
        <aside x-show="mobileMenu" x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-x-6"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 -translate-x-6"
            class="fixed inset-y-0 left-0 z-[70] w-[275px] bg-white shadow-2xl shadow-gray-900/20 flex flex-col lg:hidden">

            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <a href="{{ route('home') }}" wire:navigate @click="mobileMenu = false"
                    class="flex items-center gap-2.5">
                    <img src="{{ asset('images/logo.png') }}" alt="" class="w-8 h-8 rounded-lg object-contain">
                    <span class="font-heading font-bold text-lg text-gray-900">
                        Suhastra<span class="text-indigo-500">Dev</span>
                    </span>
                </a>
                <button @click="mobileMenu = false"
                    class="p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all active:scale-90">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-3 py-3 space-y-0.5 overflow-y-auto">
                @php
                $sidebarIcons = [
                'home' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25',
                'about' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z',
                'portfolio.index' => 'M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776',
                'products.index' => 'M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9',
                'services.index' => 'M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z',
                'contact' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75',
                ];
                @endphp

                @foreach ($navItems as $item)
                @php $path = parse_url(route($item['route']), PHP_URL_PATH) ?: '/'; @endphp
                <a href="{{ route($item['route']) }}" wire:navigate
                    @click="mobileMenu = false"
                    class="sidebar-link group"
                    :class="isActive('{{ $path }}')
                           ? 'is-active text-indigo-700 bg-indigo-50/80'
                           : 'text-gray-600 hover:text-indigo-600 hover:bg-gray-50'">
                    <svg class="w-[18px] h-[18px] shrink-0 transition-colors duration-200"
                        :class="isActive('{{ $path }}') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-400'"
                        fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="{{ $sidebarIcons[$item['route']] ?? 'M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25' }}" />
                    </svg>
                    <span class="flex-1">{{ $item['label'] }}</span>
                    <svg class="w-3.5 h-3.5 shrink-0 transition-all duration-200"
                        :class="isActive('{{ $path }}') ? 'opacity-100 text-indigo-400' : 'opacity-0 group-hover:opacity-40 text-gray-400'"
                        fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
                @endforeach
            </nav>

            <div class="p-4 border-t border-gray-100 space-y-2.5">
                <a href="{{ route('lang.switch', app()->getLocale() === 'id' ? 'en' : 'id') }}"
                    class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-sm font-medium text-gray-600 bg-gray-50 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 border border-gray-200/70 transition-all active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                    </svg>
                    {{ app()->getLocale() === 'id' ? 'Switch to English' : 'Ganti ke Indonesia' }}
                </a>
                <a href="{{ route('contact') }}" wire:navigate @click="mobileMenu = false"
                    class="flex items-center justify-center gap-2 w-full px-4 py-3 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-violet-600 rounded-xl hover:from-indigo-500 hover:to-violet-500 shadow-md shadow-indigo-500/20 transition-all active:scale-95">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z" />
                    </svg>
                    {{ __('Hubungi Saya') }}
                </a>
            </div>
        </aside>

        <script>
            function appNav() {
                return {
                    scrolled: false,
                    mobileMenu: false,
                    currentPath: window.location.pathname,
                    _handler: null,

                    init() {
                        this.scrolled = window.scrollY > 60;
                        this._handler = () => {
                            this.scrolled = window.scrollY > 60;
                        };
                        window.addEventListener('scroll', this._handler, {
                            passive: true
                        });

                        document.addEventListener('keydown', e => {
                            if (e.key === 'Escape') this.mobileMenu = false;
                        });

                        document.addEventListener('livewire:navigated', () => {
                            this.currentPath = window.location.pathname;
                            this.mobileMenu = false;
                            window.scrollTo({
                                top: 0,
                                behavior: 'instant'
                            });
                        });
                    },

                    destroy() {
                        if (this._handler) window.removeEventListener('scroll', this._handler);
                    },

                    isActive(path) {
                        if (path === '/') return this.currentPath === '/';
                        return this.currentPath === path || this.currentPath.startsWith(path + '/');
                    }
                };
            }
        </script>
    </div>
    @endpersist


    {{-- ╔══════════════════════════════╗
         ║  FLASH MESSAGES              ║
         ╚══════════════════════════════╝ --}}
    @if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-full"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-full"
        class="fixed top-[76px] right-4 z-[80] w-full max-w-sm">
        <div class="bg-white border border-green-100 rounded-2xl p-4 shadow-2xl flex items-start gap-3">
            <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>
            <div class="flex-1 pt-0.5">
                <p class="text-sm font-semibold text-gray-900">{{ __('Berhasil!') }}</p>
                <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-gray-300 hover:text-gray-500 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    @endif

    @if (session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-full"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-full"
        class="fixed top-[76px] right-4 z-[80] w-full max-w-sm">
        <div class="bg-white border border-red-100 rounded-2xl p-4 shadow-2xl flex items-start gap-3">
            <div class="w-8 h-8 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            </div>
            <div class="flex-1 pt-0.5">
                <p class="text-sm font-semibold text-gray-900">{{ __('Oops!') }}</p>
                <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ session('error') }}</p>
            </div>
            <button @click="show = false" class="text-gray-300 hover:text-gray-500 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    @endif


    {{-- ╔══════════════════════════════╗
         ║  MAIN CONTENT                ║
         ╚══════════════════════════════╝ --}}
    <main id="main-content">
        @yield('content')
    </main>


    {{-- ╔══════════════════════════════╗
         ║  FOOTER  (@persist)          ║
         ╚══════════════════════════════╝ --}}
    @persist('footer')
    <footer class="relative bg-[#0c0f1a] text-white overflow-hidden">

        <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-indigo-500/50 to-transparent"></div>
        <div class="absolute top-0 right-0 w-[520px] h-[520px] bg-indigo-600/4 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[420px] h-[420px] bg-violet-600/4 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="pt-16 pb-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8">

                <div class="lg:col-span-5 space-y-5">
                    <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center gap-2.5 group">
                        <img src="{{ asset('images/logo.png') }}" alt="SuhastraDev"
                            class="w-10 h-10 rounded-xl object-contain transition-transform duration-300 group-hover:scale-105">
                        <span class="font-heading font-bold text-xl text-white leading-none">
                            Suhastra<span class="text-indigo-400">Dev</span>
                        </span>
                    </a>
                    <p class="text-sm text-gray-500 leading-relaxed max-w-[340px]">
                        {{ setting('site_description', 'Web developer berpengalaman yang menyediakan jasa pembuatan website berkualitas dan marketplace source code siap pakai.') }}
                    </p>
                    <div class="flex items-center gap-2.5 pt-1">
                        @if (setting('contact_github'))
                        <a href="{{ setting('contact_github') }}" target="_blank" rel="noopener" aria-label="GitHub"
                            class="group w-10 h-10 bg-white/5 hover:bg-indigo-600 border border-white/[.08] hover:border-indigo-600 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-indigo-600/25">
                            <svg class="w-[18px] h-[18px] text-gray-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                            </svg>
                        </a>
                        @endif
                        @if (setting('contact_linkedin'))
                        <a href="{{ setting('contact_linkedin') }}" target="_blank" rel="noopener" aria-label="LinkedIn"
                            class="group w-10 h-10 bg-white/5 hover:bg-blue-600 border border-white/[.08] hover:border-blue-600 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-blue-600/25">
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                        @endif
                        @if (setting('contact_instagram'))
                        <a href="{{ setting('contact_instagram') }}" target="_blank" rel="noopener" aria-label="Instagram"
                            class="group w-10 h-10 bg-white/5 border border-white/[.08] hover:border-pink-500 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-pink-600/25">
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-pink-400 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <h4 class="text-[.7rem] font-bold uppercase tracking-widest text-gray-600 mb-5">{{ __('Navigasi') }}</h4>
                    <ul class="space-y-2.5">
                        @foreach([
                        ['route' => 'home', 'label' => __('Home')],
                        ['route' => 'about', 'label' => __('Tentang Saya')],
                        ['route' => 'portfolio.index', 'label' => __('Portfolio')],
                        ['route' => 'products.index', 'label' => __('Produk')],
                        ['route' => 'services.index', 'label' => __('Layanan')],
                        ['route' => 'contact', 'label' => __('Kontak')],
                        ['route' => 'order.status', 'label' => __('Cek Pesanan')],
                        ] as $link)
                        <li>
                            <a href="{{ route($link['route']) }}" wire:navigate
                                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-indigo-400 transition-all duration-200 hover:translate-x-1 group">
                                <span class="w-1 h-1 rounded-full bg-indigo-500/50 opacity-0 group-hover:opacity-100 transition-opacity shrink-0"></span>
                                {{ $link['label'] }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="lg:col-span-4">
                    <h4 class="text-[.7rem] font-bold uppercase tracking-widest text-gray-600 mb-5">{{ __('Kontak') }}</h4>
                    <ul class="space-y-3">
                        @if (setting('contact_email'))
                        <li>
                            <a href="mailto:{{ setting('contact_email') }}"
                                class="group flex items-center gap-3 transition-transform duration-200 hover:translate-x-1">
                                <div class="w-9 h-9 bg-white/[.04] group-hover:bg-indigo-600/15 border border-white/[.06] rounded-xl flex items-center justify-center shrink-0 transition-colors duration-300">
                                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-500 group-hover:text-indigo-400 transition-colors truncate">{{ setting('contact_email') }}</span>
                            </a>
                        </li>
                        @endif
                        @if (setting('contact_phone'))
                        <li>
                            <a href="tel:{{ setting('contact_phone') }}"
                                class="group flex items-center gap-3 transition-transform duration-200 hover:translate-x-1">
                                <div class="w-9 h-9 bg-white/[.04] group-hover:bg-indigo-600/15 border border-white/[.06] rounded-xl flex items-center justify-center shrink-0 transition-colors duration-300">
                                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-500 group-hover:text-indigo-400 transition-colors">{{ setting('contact_phone') }}</span>
                            </a>
                        </li>
                        @endif
                        @if (setting('contact_whatsapp'))
                        <li>
                            <a href="https://wa.me/{{ setting('contact_whatsapp') }}" target="_blank"
                                class="group flex items-center gap-3 transition-transform duration-200 hover:translate-x-1">
                                <div class="w-9 h-9 bg-white/[.04] group-hover:bg-green-600/15 border border-white/[.06] rounded-xl flex items-center justify-center shrink-0 transition-colors duration-300">
                                    <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-500 group-hover:text-green-400 transition-colors">WhatsApp</span>
                            </a>
                        </li>
                        @endif
                        @if (setting('contact_address'))
                        <li class="flex items-start gap-3">
                            <div class="w-9 h-9 bg-white/[.04] border border-white/[.06] rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                            </div>
                            <span class="text-sm text-gray-500 leading-relaxed pt-2">{{ setting('contact_address') }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/[.05] py-6 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-gray-600">
                    {{ setting('footer_text', '© ' . date('Y') . ' SuhastraDev. All rights reserved.') }}
                </p>
                <span class="flex items-center gap-1.5 text-xs text-gray-700">
                    Made with
                    <svg class="w-3 h-3 text-red-500/60 fill-current" viewBox="0 0 24 24">
                        <path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402z" />
                    </svg>
                    in Indonesia
                </span>
            </div>
        </div>
    </footer>
    @endpersist


    {{-- ╔══════════════════════════════╗
         ║  WHATSAPP  (@persist)        ║
         ╚══════════════════════════════╝ --}}
    @persist('wa-button')
    @if (setting('contact_whatsapp'))
    <div x-data="{ tip: false, visible: false }"
        x-init="setTimeout(() => visible = true, 1200)"
        class="fixed bottom-6 right-6 z-50">
        <div x-show="visible"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 scale-50 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            <a href="https://wa.me/{{ setting('contact_whatsapp') }}?text={{ urlencode(__('Halo, saya tertarik dengan jasa Anda.')) }}"
                target="_blank" rel="noopener"
                @mouseenter="tip = true" @mouseleave="tip = false"
                class="relative group w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 text-white rounded-2xl flex items-center justify-center shadow-xl shadow-green-500/30 transition-all duration-300 hover:scale-110 hover:-translate-y-1 hover:rounded-xl hover:shadow-2xl hover:shadow-green-500/40"
                aria-label="Chat via WhatsApp">
                <span class="wa-ring"></span>
                <svg class="w-6 h-6 relative z-10 transition-transform duration-300 group-hover:rotate-12" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
                <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-green-300 rounded-full border-2 border-white animate-pulse"></span>
            </a>
            <div x-show="tip"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 translate-x-2"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 translate-x-2"
                class="absolute right-[calc(100%+10px)] top-1/2 -translate-y-1/2 bg-gray-900 text-white text-xs font-medium px-3 py-2 rounded-xl whitespace-nowrap shadow-xl pointer-events-none">
                {{ __('Chat via WhatsApp') }}
                <span class="absolute -right-1 top-1/2 -translate-y-1/2 w-2 h-2 bg-gray-900 rotate-45 rounded-[1px]"></span>
            </div>
        </div>
    </div>
    @endif
    @endpersist


    @livewireScripts

    {{-- ╔══════════════════════════════════════════════════════════╗
         ║  PAGE TRANSITION SCRIPT                                  ║
         ║                                                          ║
         ║  Timeline saat wire:navigate diklik:                     ║
         ║  0ms    → livewire:navigate    → tambah .page-leaving    ║
         ║  120ms  → fade out selesai     → Livewire fetch halaman  ║
         ║  ~200ms → livewire:navigating  → konten lama pergi       ║
         ║  ~300ms → livewire:navigated   → konten baru masuk       ║
         ║           → hapus .leaving, set opacity:0               ║
         ║           → requestAnimationFrame → tambah transition    ║
         ║           → opacity menjadi 1 → fade in smooth          ║
         ╚══════════════════════════════════════════════════════════╝ --}}
    <script>
        (() => {
            const main = () => document.getElementById('main-content');

            // STEP 1: User klik link → konten lama fade+slide ke atas
            document.addEventListener('livewire:navigate', () => {
                const el = main();
                if (!el) return;
                el.classList.add('page-leaving');
            });

            // STEP 2: Konten baru sudah di-swap oleh Livewire → fade in
            document.addEventListener('livewire:navigated', () => {
                const el = main();
                if (!el) return;

                // Pastikan dalam keadaan invisible dulu (tanpa transition)
                el.classList.remove('page-leaving');
                el.classList.add('page-entering');

                // Tunggu 1 frame agar browser merender opacity:0 dulu
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        // Baru aktifkan transition dan set ke visible
                        el.classList.add('page-entering-active');
                        el.classList.remove('page-entering');

                        // Bersihkan class setelah animasi selesai
                        el.addEventListener('transitionend', () => {
                            el.classList.remove('page-entering-active');
                        }, {
                            once: true
                        });
                    });
                });
            });
        })();
    </script>

    @stack('scripts')
</body>

</html>