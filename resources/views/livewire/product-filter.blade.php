<div>
    {{-- Search & Category Filter --}}
    <div class="flex flex-col sm:flex-row gap-4 justify-between items-center mb-8">
        <div class="flex flex-wrap gap-2">
            <button wire:click="filterCategory(null)"
                class="px-4 py-2 text-sm font-medium rounded-xl transition-all duration-300 {{ !$categoryId ? 'bg-gradient-to-r from-primary-600 to-indigo-600 text-white shadow-md shadow-primary-600/25' : 'text-dark-600 bg-gray-100 hover:bg-primary-50 hover:text-primary-600' }}">
                {{ __('Semua') }}
            </button>
            @foreach ($categories as $cat)
            <button wire:click="filterCategory({{ $cat->id }})"
                class="px-4 py-2 text-sm font-medium rounded-xl transition-all duration-300 {{ $categoryId === $cat->id ? 'bg-gradient-to-r from-primary-600 to-indigo-600 text-white shadow-md shadow-primary-600/25' : 'text-dark-600 bg-gray-100 hover:bg-primary-50 hover:text-primary-600' }}">
                {{ $cat->translated_name }}
            </button>
            @endforeach
        </div>
        <div class="relative w-full sm:w-64">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="{{ __('Cari produk...') }}"
                class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-gray-50 focus:bg-white transition-colors duration-300">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-dark-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
    </div>

    {{-- Tags --}}
    <div class="flex flex-wrap gap-2 mb-10">
        @foreach ($tags as $tag)
        <button wire:click="filterTag({{ $tag->id }})"
            class="px-3 py-1.5 text-xs font-medium rounded-full transition-all duration-300 {{ $tagId === $tag->id ? 'bg-primary-600 text-white shadow-sm shadow-primary-600/25' : 'text-dark-500 bg-gray-100 hover:bg-primary-50 hover:text-primary-600' }}">
            #{{ $tag->name }}
        </button>
        @endforeach
    </div>

    {{-- Product Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" wire:loading.class="opacity-50">
        @forelse ($products as $product)
        <a href="{{ route('products.show', $product->slug) }}"
            class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-primary-200 hover:shadow-xl transition-all duration-500 hover:-translate-y-2 card-glow">
            <div class="aspect-video bg-gray-100 overflow-hidden relative">
                @if ($product->thumbnail)
                <img src="{{ asset('storage/' . $product->thumbnail) }}"
                    alt="{{ $product->translated_title }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                    loading="lazy">
                @else
                <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-50 flex items-center justify-center">
                    <svg class="w-12 h-12 text-primary-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-dark-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                @if ($product->created_at->diffInDays(now()) <= 14)
                    <span class="absolute top-3 right-3 px-2.5 py-1 text-xs font-bold bg-amber-400 text-amber-900 rounded-full shadow-sm">{{ __('Baru') }}</span>
                    @endif
            </div>
            <div class="p-5">
                @if ($product->category)
                <span class="px-2.5 py-0.5 text-xs font-medium bg-primary-50 text-primary-700 rounded-full">{{ $product->category->translated_name }}</span>
                @endif
                <h3 class="font-heading font-semibold text-dark-900 group-hover:text-primary-600 transition-colors mt-2">{{ $product->translated_title }}</h3>
                <p class="text-sm text-dark-500 mt-1.5 line-clamp-2">{{ Str::limit(strip_tags($product->translated_description), 80) }}</p>
                <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                    <p class="font-heading font-bold text-primary-600">{{ $product->formatted_price }}</p>
                    <div class="flex items-center gap-1 text-xs text-dark-400">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        {{ $product->download_count }}
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-20 text-dark-400">
            <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-dark-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
            </div>
            <p class="text-lg font-semibold text-dark-700">{{ __('Tidak ada produk ditemukan.') }}</p>
            <p class="text-sm text-dark-400 mt-1">{{ __('Coba ubah filter atau kata kunci pencarian.') }}</p>
            @if ($search || $categoryId || $tagId)
            <button wire:click="$set('search', ''); $set('categoryId', null); $set('tagId', null)" class="mt-4 inline-flex items-center px-5 py-2.5 text-sm text-primary-600 hover:text-primary-700 font-semibold bg-primary-50 hover:bg-primary-100 rounded-xl transition-colors duration-300">{{ __('Reset Filter') }}</button>
            @endif
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($products->hasPages())
    <div class="mt-10">
        {{ $products->links() }}
    </div>
    @endif
</div>
