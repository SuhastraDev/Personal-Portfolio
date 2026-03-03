<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin SuhastraDev</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="h-full">
    <div class="min-h-full lg:h-screen lg:flex lg:overflow-hidden">

        {{-- Admin Sidebar (persisted across SPA navigations) --}}
        @persist('admin-sidebar')
        <div x-data="adminNav()" x-on:livewire:navigated.window="onNavigated()" x-on:toggle-sidebar.window="sidebarOpen = true">

            {{-- Mobile sidebar overlay --}}
            <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-40 bg-gray-600/75 lg:hidden" @click="sidebarOpen = false">
            </div>

            {{-- Sidebar --}}
            <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto lg:z-auto lg:shrink-0 lg:h-screen flex flex-col">

                {{-- Logo --}}
                <div class="flex h-16 items-center justify-between px-6 bg-gray-950 shrink-0">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo.png') }}" alt="SuhastraDev" class="w-8 h-8 rounded-lg object-contain">
                        <span class="text-white font-bold text-lg">SuhastraDev</span>
                    </a>
                    <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Navigation (scrollable) --}}
                <nav class="flex-1 overflow-y-auto mt-4 px-3 space-y-1 pb-4 scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-transparent">
                    {{-- Dashboard --}}
                    @php $p = parse_url(route('admin.dashboard'), PHP_URL_PATH); @endphp
                    <a href="{{ route('admin.dashboard') }}" wire:navigate
                        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                        :class="isActive('{{ $p }}') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white'">
                        <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Dashboard
                    </a>

                    {{-- Separator: Konten --}}
                    <div class="pt-4 pb-1">
                        <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Konten</p>
                    </div>

                    {{-- Settings --}}
                    @php $p = parse_url(route('admin.settings.index'), PHP_URL_PATH); @endphp
                    <a href="{{ route('admin.settings.index') }}" wire:navigate
                        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                        :class="isActive('{{ $p }}') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white'">
                        <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Pengaturan
                    </a>

                    {{-- Skills --}}
                    @php $p = parse_url(route('admin.skills.index'), PHP_URL_PATH); @endphp
                    <a href="{{ route('admin.skills.index') }}" wire:navigate
                        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                        :class="isActive('{{ $p }}') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white'">
                        <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                        </svg>
                        Skills
                    </a>

                    {{-- Testimonials --}}
                    @php $p = parse_url(route('admin.testimonials.index'), PHP_URL_PATH); @endphp
                    <a href="{{ route('admin.testimonials.index') }}" wire:navigate
                        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                        :class="isActive('{{ $p }}') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white'">
                        <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                        </svg>
                        Testimoni
                    </a>

                    {{-- Separator: Portfolio --}}
                    <div class="pt-4 pb-1">
                        <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Portfolio</p>
                    </div>

                    {{-- Portfolios --}}
                    @php $p = parse_url(route('admin.portfolios.index'), PHP_URL_PATH); @endphp
                    <a href="{{ route('admin.portfolios.index') }}" wire:navigate
                        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                        :class="isActive('{{ $p }}') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white'">
                        <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v13.5A1.5 1.5 0 003.75 21z" />
                        </svg>
                        Portfolio
                    </a>

                    {{-- Portfolio Categories --}}
                    @php $p = parse_url(route('admin.portfolio-categories.index'), PHP_URL_PATH); @endphp
                    <a href="{{ route('admin.portfolio-categories.index') }}" wire:navigate
                        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                        :class="isActive('{{ $p }}') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white'">
                        <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                        </svg>
                        Kategori Portfolio
                    </a>

                    {{-- Separator: Produk --}}
                    <div class="pt-4 pb-1">
                        <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</p>
                    </div>

                    {{-- Products --}}
                    @php $p = parse_url(route('admin.products.index'), PHP_URL_PATH); @endphp
                    <a href="{{ route('admin.products.index') }}" wire:navigate
                        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                        :class="isActive('{{ $p }}') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white'">
                        <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                        Produk
                    </a>

                    {{-- Product Categories --}}
                    @php $p = parse_url(route('admin.product-categories.index'), PHP_URL_PATH); @endphp
                    <a href="{{ route('admin.product-categories.index') }}" wire:navigate
                        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                        :class="isActive('{{ $p }}') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white'">
                        <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                        </svg>
                        Kategori Produk
                    </a>

                    {{-- Product Tags --}}
                    @php $p = parse_url(route('admin.product-tags.index'), PHP_URL_PATH); @endphp
                    <a href="{{ route('admin.product-tags.index') }}" wire:navigate
                        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                        :class="isActive('{{ $p }}') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white'">
                        <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5l-3.9 19.5m-2.1-19.5l-3.9 19.5" />
                        </svg>
                        Tag Produk
                    </a>

                    {{-- Orders --}}
                    @php $p = parse_url(route('admin.orders.index'), PHP_URL_PATH); @endphp
                    <a href="{{ route('admin.orders.index') }}" wire:navigate
                        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                        :class="isActive('{{ $p }}') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white'">
                        <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121 0 2.09-.773 2.34-1.867l1.58-6.921H5.256M8.25 20.25a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM17.25 20.25a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                        </svg>
                        Order
                    </a>

                    {{-- Separator: Layanan --}}
                    <div class="pt-4 pb-1">
                        <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Lainnya</p>
                    </div>

                    {{-- Services --}}
                    @php $p = parse_url(route('admin.services.index'), PHP_URL_PATH); @endphp
                    <a href="{{ route('admin.services.index') }}" wire:navigate
                        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                        :class="isActive('{{ $p }}') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white'">
                        <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.384 3.161a.75.75 0 01-1.072-.86l1.53-5.82-4.54-3.69a.75.75 0 01.44-1.32l5.926-.37 2.277-5.458a.75.75 0 011.345 0l2.276 5.457 5.927.37a.75.75 0 01.44 1.32l-4.54 3.69 1.53 5.82a.75.75 0 01-1.072.86L12 15.17l-.58.355z" />
                        </svg>
                        Layanan
                    </a>

                    {{-- Contacts / Messages --}}
                    @php $p = parse_url(route('admin.contacts.index'), PHP_URL_PATH); @endphp
                    <a href="{{ route('admin.contacts.index') }}" wire:navigate
                        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                        :class="isActive('{{ $p }}') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white'">
                        <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                        Pesan
                        @if($unreadMessagesCount > 0)
                        <span class="ml-auto inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                            {{ $unreadMessagesCount }}
                        </span>
                        @endif
                    </a>
                </nav>

                {{-- User section at bottom --}}
                <div class="shrink-0 border-t border-gray-800 px-3 py-4 space-y-1">
                    {{-- Ubah Password --}}
                    @php $p = parse_url(route('admin.change-password'), PHP_URL_PATH); @endphp
                    <a href="{{ route('admin.change-password') }}" wire:navigate
                        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors"
                        :class="isActive('{{ $p }}') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white'">
                        <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                        Ubah Password
                    </a>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="group flex items-center w-full px-3 py-2.5 text-sm font-medium rounded-lg transition-colors text-gray-300 hover:bg-red-600/20 hover:text-red-400">
                            <svg class="mr-3 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

        </div>
        @endpersist

        {{-- Main Content --}}
        <div class="lg:flex-1 min-w-0 lg:overflow-y-auto">
            {{-- Top Header --}}
            <header class="sticky top-0 z-30 bg-white border-b border-gray-200">
                <div class="flex h-14 sm:h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
                    {{-- Left: hamburger + title --}}
                    <div class="flex items-center gap-3">
                        {{-- Mobile menu button (vanilla JS — works outside Alpine scope) --}}
                        <button onclick="window.dispatchEvent(new CustomEvent('toggle-sidebar'))" class="lg:hidden text-gray-500 hover:text-gray-700 -ml-1 p-1">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>

                        {{-- Page Title --}}
                        <h1 class="text-base sm:text-lg font-semibold text-gray-900 truncate">
                            @yield('title', 'Dashboard')
                        </h1>
                    </div>

                    {{-- Right side --}}
                    <div class="flex items-center space-x-4">
                        {{-- Visit Site --}}
                        <a href="{{ route('home') }}" target="_blank"
                            class="text-sm text-gray-500 hover:text-gray-700 hidden sm:flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                            <span>Lihat Situs</span>
                        </a>

                        {{-- User dropdown --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-2 text-sm">
                                <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-medium text-xs">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </span>
                                </div>
                                <span class="hidden sm:block text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg ring-1 ring-black/5 py-1">
                                <a href="{{ route('admin.change-password') }}" wire:navigate class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                    Ubah Password
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="mx-4 sm:mx-6 lg:mx-8 mt-4">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-green-500 hover:text-green-700">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="mx-4 sm:mx-6 lg:mx-8 mt-4">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="text-red-500 hover:text-red-700">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            @endif

            {{-- Page Content --}}
            <main class="p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function adminNav() {
            return {
                sidebarOpen: false,
                currentPath: window.location.pathname,

                onNavigated() {
                    this.currentPath = window.location.pathname;
                    this.sidebarOpen = false;
                },

                isActive(path) {
                    return this.currentPath.startsWith(path);
                }
            };
        }
    </script>

    @livewireScripts
    @stack('scripts')
</body>

</html>