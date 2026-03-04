@extends('layouts.app')

@section('title', __('Status Pesanan'))
@section('meta_title', __('Status Pesanan') . ' — ' . $order->order_number)

@section('content')
<section class="bg-gradient-to-br from-dark-950 via-dark-900 to-primary-950 pt-32 pb-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-grid-pattern bg-grid"></div>
    </div>
    <div class="absolute top-1/4 right-10 w-64 h-64 bg-primary-500/10 rounded-full blur-[80px]"></div>
    <div class="absolute top-20 right-20 w-20 h-20 border border-white/10 rounded-2xl rotate-12 animate-float hidden sm:block"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur-md text-primary-300 text-xs font-semibold rounded-full uppercase tracking-wider mb-5 border border-white/10 shadow-sm" data-aos="fade-up">
                <i class="fa-solid fa-receipt"></i> Order Status
            </span>
            <h1 class="font-heading text-4xl sm:text-5xl font-bold text-white mb-4" data-aos="fade-up" data-aos-delay="100">{{ __('Status Pesanan') }}</h1>
            <p class="text-dark-300 max-w-xl mx-auto text-lg" data-aos="fade-up" data-aos-delay="150">Order: <span class="font-mono text-white">{{ $order->order_number }}</span></p>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Status Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-lg overflow-hidden" data-aos="fade-up">

            {{-- Status Banner --}}
            @if ($order->status === 'paid')
            <div class="bg-green-50 border-b border-green-100 px-6 py-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-green-500/25">
                    <i class="fa-solid fa-check text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="font-semibold text-green-800">{{ __('Pembayaran Berhasil!') }}</h2>
                    <p class="text-sm text-green-600">{{ __('Terima kasih, pembayaran Anda telah dikonfirmasi.') }}</p>
                </div>
            </div>
            @elseif ($order->status === 'pending')
            <div class="bg-yellow-50 border-b border-yellow-100 px-6 py-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-yellow-500/25">
                    <i class="fa-solid fa-clock text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="font-semibold text-yellow-800">{{ __('Menunggu Pembayaran') }}</h2>
                    <p class="text-sm text-yellow-600">{{ __('Silakan selesaikan pembayaran Anda.') }}</p>
                </div>
            </div>
            @elseif ($order->status === 'expired' || $order->status === 'cancelled')
            <div class="bg-red-50 border-b border-red-100 px-6 py-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-red-500/25">
                    <i class="fa-solid fa-xmark text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="font-semibold text-red-800">{{ __('Pembayaran Gagal / Expired') }}</h2>
                    <p class="text-sm text-red-600">{{ __('Pembayaran telah dibatalkan atau kedaluwarsa.') }}</p>
                </div>
            </div>
            @endif

            {{-- Order Details --}}
            <div class="p-6 space-y-4">
                <div class="flex items-center gap-4 pb-4 border-b border-gray-100">
                    @if ($order->product && $order->product->thumbnail)
                    <img src="{{ asset('storage/' . $order->product->thumbnail) }}" alt="{{ $order->product->title }}"
                        class="w-16 h-12 rounded-lg object-cover">
                    @else
                    <div class="w-16 h-12 bg-gradient-to-br from-primary-100 to-primary-50 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-code text-primary-400"></i>
                    </div>
                    @endif
                    <div>
                        <h3 class="font-semibold text-dark-900">{{ $order->product->title ?? __('Produk') }}</h3>
                        <p class="text-sm text-gray-500">{{ $order->order_number }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 block">{{ __('Pembeli') }}</span>
                        <span class="font-medium text-dark-800">{{ $order->buyer_name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">{{ __('Email') }}</span>
                        <span class="font-medium text-dark-800">{{ $order->buyer_email }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">{{ __('Total') }}</span>
                        <span class="font-bold text-primary-600">{{ $order->formatted_amount }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">{{ __('Status') }}</span>
                        @if ($order->status === 'paid')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                            <i class="fa-solid fa-circle-check text-[10px]"></i> {{ __('Lunas') }}
                        </span>
                        @elseif ($order->status === 'pending')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">
                            <i class="fa-solid fa-clock text-[10px]"></i> {{ __('Pending') }}
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-red-100 text-red-700 text-xs font-semibold rounded-full">
                            <i class="fa-solid fa-circle-xmark text-[10px]"></i> {{ ucfirst($order->status) }}
                        </span>
                        @endif
                    </div>
                    @if ($order->payment_method)
                    <div class="col-span-2">
                        <span class="text-gray-500 block">{{ __('Metode Pembayaran') }}</span>
                        <span class="font-medium text-dark-800">{{ strtoupper($order->payment_method) }}</span>
                    </div>
                    @endif
                </div>

                {{-- Download Button --}}
                @if ($order->isDownloadable())
                <div class="pt-4 border-t border-gray-100">
                    <a href="{{ route('download', $order->download_token) }}"
                        class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-500 hover:to-indigo-500 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg shadow-primary-600/25 hover:shadow-xl hover:shadow-primary-600/40 hover:-translate-y-0.5">
                        <i class="fa-solid fa-download mr-2"></i>
                        {{ __('Download Produk') }}
                    </a>
                    <div class="mt-3 flex items-start gap-2 p-3 bg-amber-50 rounded-lg">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500 text-xs mt-0.5"></i>
                        <p class="text-xs text-amber-700">
                            {{ __('Download tersisa:') }} <strong>{{ 2 - $order->download_count }}x</strong> •
                            {{ __('Berlaku hingga:') }} <strong>{{ $order->download_expires_at ? $order->download_expires_at->format('d M Y, H:i') . ' WIB' : '-' }}</strong>
                        </p>
                    </div>
                </div>
                @elseif ($order->status === 'paid')
                <div class="pt-4 border-t border-gray-100">
                    <div class="p-3 bg-red-50 rounded-lg text-sm text-red-700">
                        <i class="fa-solid fa-circle-exclamation mr-1"></i>
                        {{ __('Batas download telah habis atau link sudah kedaluwarsa. Silakan hubungi admin.') }}
                    </div>
                </div>
                @endif

                @if ($order->status === 'pending')
                <div class="pt-4 border-t border-gray-100">
                    <div class="p-3 bg-blue-50 rounded-lg text-sm text-blue-700">
                        <i class="fa-solid fa-info-circle mr-1"></i>
                        {{ __('Setelah pembayaran dikonfirmasi, link download akan dikirim ke email') }} <strong>{{ $order->buyer_email }}</strong>.
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center" data-aos="fade-up" data-aos-delay="100">
            <a href="{{ route('products.index') }}" wire:navigate
                class="inline-flex items-center justify-center px-6 py-3.5 bg-gray-100 hover:bg-gray-200 text-dark-700 font-semibold rounded-2xl transition-all duration-300 hover:-translate-y-0.5">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                {{ __('Kembali ke Produk') }}
            </a>
            <a href="{{ route('order.status') }}" wire:navigate
                class="inline-flex items-center justify-center px-6 py-3.5 bg-white border border-gray-200 hover:bg-gray-50 hover:border-primary-200 text-dark-700 font-semibold rounded-2xl transition-all duration-300 hover:-translate-y-0.5">
                <i class="fa-solid fa-magnifying-glass mr-2"></i>
                {{ __('Cek Status Pesanan') }}
            </a>
        </div>
    </div>
</section>
@endsection