@extends('layouts.app')

@section('title', $product->translated_title)
@section('meta_title', $product->translated_meta_title ?: $product->translated_title)
@section('meta_description', $product->translated_meta_description ?: Str::limit(strip_tags($product->translated_description), 160))

@if($product->thumbnail)
@section('og_image', asset('storage/' . $product->thumbnail))
@endif

@section('content')
{{-- Header --}}
<section class="bg-gradient-to-br from-dark-950 via-dark-900 to-primary-950 pt-32 pb-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-grid-pattern bg-grid"></div>
    </div>
    <div class="absolute top-1/4 right-10 w-64 h-64 bg-primary-500/10 rounded-full blur-[80px]"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-sm text-dark-400 mb-6" data-aos="fade-up">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors duration-200">{{ __('Home') }}</a>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
            <a href="{{ route('products.index') }}" class="hover:text-white transition-colors duration-200">{{ __('Produk') }}</a>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
            <span class="text-white font-medium">{{ $product->translated_title }}</span>
        </nav>
        <h1 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-5" data-aos="fade-up" data-aos-delay="100">{{ $product->translated_title }}</h1>
        <div class="flex flex-wrap items-center gap-3" data-aos="fade-up" data-aos-delay="150">
            @if ($product->category)
            <span class="px-3 py-1.5 text-xs font-semibold bg-white/10 backdrop-blur-sm text-white rounded-full border border-white/10">{{ $product->category->translated_name }}</span>
            @endif
            @foreach ($product->tags as $tag)
            <span class="px-3 py-1.5 text-xs font-medium bg-white/5 text-dark-300 rounded-full border border-white/5">#{{ $tag->name }}</span>
            @endforeach
        </div>
    </div>
</section>

{{-- Product Detail --}}
<section class="py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Main Content --}}
            <div class="lg:col-span-2">
                {{-- Thumbnail --}}
                @if ($product->thumbnail)
                <div class="rounded-2xl overflow-hidden shadow-2xl mb-10 img-zoom" data-aos="fade-up">
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->translated_title }}" class="w-full">
                </div>
                @endif

                {{-- Description --}}
                <div class="prose prose-lg max-w-none text-dark-700 mb-10" data-aos="fade-up">
                    {!! nl2br(e($product->translated_description)) !!}
                </div>

                {{-- Features --}}
                @if (!empty($product->translated_features))
                <div class="mb-10" data-aos="fade-up">
                    <h3 class="font-heading text-xl font-bold text-dark-900 mb-5 flex items-center gap-2">
                        <span class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-check text-xs text-green-600"></i>
                        </span>
                        {{ __('Fitur') }}
                    </h3>
                    <ul class="space-y-3">
                        @foreach ($product->translated_features as $index => $feature)
                        <li class="flex items-start gap-3 text-dark-600 group" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                            <span class="w-6 h-6 bg-green-100 group-hover:bg-green-200 rounded-lg flex items-center justify-center shrink-0 mt-0.5 transition-colors duration-300">
                                <svg class="w-3.5 h-3.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </span>
                            <span class="text-sm leading-relaxed">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Gallery --}}
                @if ($product->images->count() > 0)
                <div class="mb-10">
                    <h3 class="font-heading text-xl font-bold text-dark-900 mb-5 flex items-center gap-2" data-aos="fade-up">
                        <span class="w-8 h-8 bg-primary-50 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-camera text-xs text-primary-600"></i>
                        </span>
                        {{ __('Screenshot') }}
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($product->images as $index => $image)
                        <div class="rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 img-zoom" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->translated_title }}" class="w-full" loading="lazy">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1" data-aos="fade-left">
                <div class="sticky top-24 bg-gradient-to-br from-gray-50 to-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <p class="font-heading text-3xl font-bold text-dark-900 mb-1">{{ $product->formatted_price }}</p>
                    <p class="text-sm text-dark-400 mb-6">{{ __('Sekali bayar, tanpa biaya berlangganan') }}</p>

                    {{-- Meta --}}
                    <div class="space-y-3 mb-6">
                        @if ($product->version)
                        <div class="flex justify-between text-sm py-2 border-b border-gray-100">
                            <span class="text-dark-500">{{ __('Versi') }}</span>
                            <span class="font-semibold text-dark-800">{{ $product->version }}</span>
                        </div>
                        @endif
                        @if ($product->category)
                        <div class="flex justify-between text-sm py-2 border-b border-gray-100">
                            <span class="text-dark-500">{{ __('Kategori') }}</span>
                            <span class="font-semibold text-dark-800">{{ $product->category->translated_name }}</span>
                        </div>
                        @endif
                        @if (!empty($product->tech_stack))
                        <div class="text-sm py-2 border-b border-gray-100">
                            <span class="text-dark-500 block mb-2">Tech Stack</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach ($product->tech_stack as $tech)
                                <span class="px-2.5 py-1 text-xs font-medium bg-primary-50 text-primary-700 rounded-lg">{{ $tech }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        <div class="flex justify-between text-sm py-2">
                            <span class="text-dark-500">{{ __('Download') }}</span>
                            <span class="font-semibold text-dark-800">{{ $product->download_count }}x</span>
                        </div>
                    </div>

                    {{-- Buy Now --}}
                    <a href="{{ route('checkout.show', $product->slug) }}"
                        class="group w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-500 hover:to-indigo-500 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg shadow-primary-600/25 hover:shadow-xl hover:shadow-primary-600/40 hover:-translate-y-0.5">
                        <i class="fa-solid fa-cart-shopping mr-2"></i>
                        {{ __('Beli Sekarang') }} — {{ $product->formatted_price }}
                    </a>

                    {{-- Buy via WhatsApp --}}
                    @if (setting('contact_whatsapp'))
                    @php
                    $waMessage = __("Halo, saya tertarik membeli source code:\n\n*:title*\nHarga: :price\n\nMohon info selanjutnya.", ['title' => $product->translated_title, 'price' => $product->formatted_price]);
                    @endphp
                    <a href="https://wa.me/{{ setting('contact_whatsapp') }}?text={{ urlencode($waMessage) }}"
                        target="_blank" rel="noopener"
                        class="group w-full inline-flex items-center justify-center px-6 py-3.5 mt-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-2xl transition-all duration-300 hover:shadow-lg hover:shadow-green-500/25 hover:-translate-y-0.5">
                        <i class="fa-brands fa-whatsapp mr-2 text-lg"></i>
                        {{ __('Tanya via WhatsApp') }}
                    </a>
                    @endif

                    {{-- Demo Link --}}
                    @if ($product->demo_url)
                    <a href="{{ $product->demo_url }}" target="_blank" rel="noopener"
                        class="group w-full inline-flex items-center justify-center px-6 py-3.5 mt-3 bg-white text-dark-700 font-semibold rounded-2xl border border-gray-200 hover:bg-gray-50 hover:border-primary-200 transition-all duration-300 hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                        {{ __('Lihat Demo') }}
                    </a>
                    @endif

                    {{-- Trust badge --}}
                    <div class="mt-6 flex items-start gap-3 p-4 bg-green-50/50 rounded-xl border border-green-100/50">
                        <i class="fa-solid fa-shield-halved text-green-500 mt-0.5"></i>
                        <div>
                            <p class="text-xs font-semibold text-dark-700">{{ __('Pembayaran Aman') }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ __('Transaksi aman melalui Midtrans.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Related Products --}}
@if ($relatedProducts->count() > 0)
<section class="py-16 lg:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h3 class="font-heading text-2xl font-bold text-dark-900 mb-8" data-aos="fade-up">{{ __('Produk Terkait') }}</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($relatedProducts as $index => $related)
            <a href="{{ route('products.show', $related->slug) }}" class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-primary-200 transition-all duration-500 hover:-translate-y-2 card-glow" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="aspect-video bg-gray-100 overflow-hidden relative">
                    @if ($related->thumbnail)
                    <img src="{{ asset('storage/' . $related->thumbnail) }}" alt="{{ $related->translated_title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-dark-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
                <div class="p-4">
                    <h4 class="font-semibold text-dark-900 group-hover:text-primary-600 transition-colors duration-300 text-sm">{{ $related->translated_title }}</h4>
                    <p class="text-primary-600 font-bold text-sm mt-1">{{ $related->formatted_price }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
