<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SuhastraDev') }} — Login</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex bg-gray-900 relative overflow-hidden">
        {{-- Background decoration --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 left-0 w-96 h-96 bg-indigo-600/10 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-600/10 rounded-full blur-[120px] translate-x-1/2 translate-y-1/2"></div>
            <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-indigo-500/5 rounded-full blur-[80px] -translate-x-1/2 -translate-y-1/2"></div>
        </div>

        {{-- Left panel (hidden on mobile) --}}
        <div class="hidden lg:flex lg:w-1/2 relative items-center justify-center p-12">
            <div class="relative z-10 max-w-md text-center">
                <img src="{{ asset('images/logo.png') }}" alt="SuhastraDev" class="w-20 h-20 rounded-2xl mx-auto mb-8 shadow-2xl shadow-indigo-600/30 object-contain">
                <h1 class="text-4xl font-bold text-white mb-4">SuhastraDev</h1>
                <p class="text-gray-400 text-lg leading-relaxed">
                    Admin Panel — Kelola portfolio, produk, layanan, dan semua konten website Anda dari satu tempat.
                </p>
                <div class="mt-10 flex items-center justify-center gap-8 text-gray-500">
                    <div class="text-center">
                        <div class="w-10 h-10 bg-gray-800 rounded-xl flex items-center justify-center mx-auto mb-2 border border-gray-700">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <span class="text-xs">Aman</span>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 bg-gray-800 rounded-xl flex items-center justify-center mx-auto mb-2 border border-gray-700">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                            </svg>
                        </div>
                        <span class="text-xs">Cepat</span>
                    </div>
                    <div class="text-center">
                        <div class="w-10 h-10 bg-gray-800 rounded-xl flex items-center justify-center mx-auto mb-2 border border-gray-700">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                            </svg>
                        </div>
                        <span class="text-xs">Mudah</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right panel (form area) --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative z-10">
            <div class="w-full max-w-md">
                {{-- Mobile logo --}}
                <div class="lg:hidden text-center mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="SuhastraDev" class="w-14 h-14 rounded-xl mx-auto mb-4 shadow-lg shadow-indigo-600/30 object-contain">
                    <h1 class="text-2xl font-bold text-white">SuhastraDev</h1>
                </div>

                <div class="bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-2xl p-8 shadow-2xl">
                    {{ $slot }}
                </div>

                <p class="text-center text-gray-600 text-xs mt-6">&copy; {{ date('Y') }} SuhastraDev. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>