<div>
    {{-- Filter Buttons --}}
    <div class="flex flex-wrap gap-2 justify-center mb-12">
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

    {{-- Portfolio Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" wire:loading.class="opacity-50">
        @forelse ($portfolios as $portfolio)
        <a href="{{ route('portfolio.show', $portfolio->slug) }}" wire:navigate
            class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-primary-200 hover:shadow-xl transition-all duration-500 hover:-translate-y-2 card-glow">
            <div class="aspect-video bg-gray-100 overflow-hidden relative">
                @if ($portfolio->thumbnail)
                <img src="{{ asset('storage/' . $portfolio->thumbnail) }}"
                    alt="{{ $portfolio->translated_title }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                    loading="lazy">
                @else
                <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-50 flex items-center justify-center">
                    <svg class="w-12 h-12 text-primary-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v13.5A1.5 1.5 0 003.75 21z" />
                    </svg>
                </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-dark-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </div>
            <div class="p-5">
                <div class="flex flex-wrap gap-1.5 mb-3">
                    @foreach ($portfolio->categories as $cat)
                    <span class="px-2.5 py-0.5 text-xs font-medium bg-primary-50 text-primary-700 rounded-full">{{ $cat->translated_name }}</span>
                    @endforeach
                </div>
                <h3 class="font-heading font-semibold text-dark-900 group-hover:text-primary-600 transition-colors">{{ $portfolio->translated_title }}</h3>
                <p class="text-sm text-dark-500 mt-1.5 line-clamp-2">{{ Str::limit(strip_tags($portfolio->translated_description), 100) }}</p>
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-20 text-dark-400">
            <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-dark-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v13.5A1.5 1.5 0 003.75 21z" />
                </svg>
            </div>
            <p class="text-lg font-semibold text-dark-700">{{ __('Belum ada portfolio.') }}</p>
            <p class="text-sm text-dark-400 mt-1">{{ __('Portfolio akan segera ditambahkan.') }}</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($portfolios->hasPages())
    <div class="mt-10">
        {{ $portfolios->links() }}
    </div>
    @endif
</div>
