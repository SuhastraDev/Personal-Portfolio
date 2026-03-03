{{-- Icon Picker Component --}}
{{-- Usage: @include('admin.partials.icon-picker', ['name' => 'icon', 'value' => old('icon', $model->icon ?? '')]) --}}

<div x-data="iconPicker('{{ $value ?? '' }}')" class="relative">
    <label class="block text-sm font-medium text-gray-700 mb-1">Ikon</label>

    {{-- Selected Icon Display --}}
    <div class="flex items-center gap-3">
        <button type="button" @click="togglePicker()"
            class="w-12 h-12 rounded-xl bg-indigo-50 border-2 border-indigo-200 hover:border-indigo-400 flex items-center justify-center text-indigo-600 text-xl transition-all cursor-pointer flex-shrink-0">
            <i :class="selected || 'fa-solid fa-icons'" class="transition-all"></i>
        </button>
        <div class="flex-1">
            <input type="hidden" name="{{ $name ?? 'icon' }}" :value="selected">
            <button type="button" @click="togglePicker()"
                class="w-full text-left rounded-lg border border-gray-300 bg-white shadow-sm text-sm px-3 py-2.5 cursor-pointer hover:bg-gray-50 transition-colors"
                x-text="selected || 'Klik untuk pilih ikon...'">
            </button>
        </div>
        <button type="button" x-show="selected" @click="selected = ''" x-cloak
            class="text-gray-400 hover:text-red-500 transition-colors flex-shrink-0 p-1">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Icon Picker Dropdown --}}
    <div x-show="open" x-cloak @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 mt-2 w-full bg-white rounded-xl border border-gray-200 shadow-2xl overflow-hidden">

        {{-- Search --}}
        <div class="p-3 border-b border-gray-100 sticky top-0 bg-white z-10">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" x-model="search" placeholder="Cari ikon..."
                    class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                    @keydown.escape="open = false" x-ref="searchInput">
            </div>
            {{-- Category Tabs --}}
            <div class="flex gap-1.5 mt-2.5 overflow-x-auto pb-1 scrollbar-hide">
                <template x-for="cat in categories" :key="cat.key">
                    <button type="button"
                        @click="activeCategory = cat.key"
                        :class="activeCategory === cat.key
                            ? 'bg-indigo-100 text-indigo-700 border-indigo-200'
                            : 'bg-gray-50 text-gray-500 border-gray-200 hover:bg-gray-100 hover:text-gray-700'"
                        class="px-3 py-1 text-xs font-medium rounded-full border whitespace-nowrap transition-colors"
                        x-text="cat.label">
                    </button>
                </template>
            </div>
        </div>

        {{-- Icons Grid --}}
        <div class="p-3 overflow-y-auto" style="max-height: 320px;">
            <div class="grid grid-cols-6 sm:grid-cols-8 gap-1.5">
                <template x-for="icon in filteredIcons" :key="icon.c">
                    <button type="button"
                        @click="select(icon.c)"
                        :class="selected === icon.c
                            ? 'bg-indigo-100 border-indigo-300 text-indigo-600 ring-2 ring-indigo-500/20'
                            : 'bg-gray-50 border-gray-200 text-gray-500 hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-600'"
                        class="flex flex-col items-center justify-center p-2 rounded-lg border transition-all aspect-square cursor-pointer"
                        :title="icon.n">
                        <i :class="icon.c" class="text-lg"></i>
                        <span class="text-[9px] mt-1 truncate w-full text-center leading-tight opacity-70" x-text="icon.n"></span>
                    </button>
                </template>
            </div>
            <p x-show="filteredIcons.length === 0" class="text-center text-gray-400 text-sm py-8">
                <i class="fa-solid fa-face-sad-tear text-2xl mb-2 block"></i>
                Tidak ada ikon ditemukan
            </p>
        </div>
    </div>

    @error($name ?? 'icon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

@once
@push('scripts')
<script>
    function iconPicker(initial) {
        return {
            open: false,
            search: '',
            selected: initial || '',
            activeCategory: 'all',
            categories: [{
                    key: 'all',
                    label: 'Semua'
                },
                {
                    key: 'dev',
                    label: 'Development'
                },
                {
                    key: 'biz',
                    label: 'Bisnis'
                },
                {
                    key: 'ui',
                    label: 'UI / Umum'
                },
                {
                    key: 'media',
                    label: 'Media'
                },
                {
                    key: 'brand',
                    label: 'Brands'
                },
            ],
            icons: [
                // Development / Tech
                {
                    c: 'fa-solid fa-code',
                    n: 'Code',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-terminal',
                    n: 'Terminal',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-database',
                    n: 'Database',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-server',
                    n: 'Server',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-cloud',
                    n: 'Cloud',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-globe',
                    n: 'Globe',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-laptop-code',
                    n: 'Laptop Code',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-mobile-screen-button',
                    n: 'Mobile',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-desktop',
                    n: 'Desktop',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-wifi',
                    n: 'Wifi',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-lock',
                    n: 'Lock',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-shield-halved',
                    n: 'Shield',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-bug',
                    n: 'Bug',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-microchip',
                    n: 'Microchip',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-network-wired',
                    n: 'Network',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-sitemap',
                    n: 'Sitemap',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-gear',
                    n: 'Gear',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-gears',
                    n: 'Gears',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-wrench',
                    n: 'Wrench',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-screwdriver-wrench',
                    n: 'Tools',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-hammer',
                    n: 'Hammer',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-sliders',
                    n: 'Sliders',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-code-branch',
                    n: 'Branch',
                    cat: 'dev'
                },
                {
                    c: 'fa-solid fa-file-code',
                    n: 'File Code',
                    cat: 'dev'
                },

                // Business / Commerce
                {
                    c: 'fa-solid fa-building',
                    n: 'Building',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-briefcase',
                    n: 'Briefcase',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-chart-line',
                    n: 'Chart Line',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-chart-bar',
                    n: 'Chart Bar',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-chart-pie',
                    n: 'Chart Pie',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-rocket',
                    n: 'Rocket',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-bullseye',
                    n: 'Bullseye',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-lightbulb',
                    n: 'Lightbulb',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-cart-shopping',
                    n: 'Cart',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-store',
                    n: 'Store',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-truck',
                    n: 'Truck',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-handshake',
                    n: 'Handshake',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-users',
                    n: 'Users',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-user',
                    n: 'User',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-dollar-sign',
                    n: 'Dollar',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-credit-card',
                    n: 'Credit Card',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-wallet',
                    n: 'Wallet',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-coins',
                    n: 'Coins',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-receipt',
                    n: 'Receipt',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-tags',
                    n: 'Tags',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-money-bill-wave',
                    n: 'Money',
                    cat: 'biz'
                },
                {
                    c: 'fa-solid fa-landmark',
                    n: 'Landmark',
                    cat: 'biz'
                },

                // UI / General Icons
                {
                    c: 'fa-solid fa-house',
                    n: 'House',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-magnifying-glass',
                    n: 'Search',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-star',
                    n: 'Star',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-heart',
                    n: 'Heart',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-bolt',
                    n: 'Bolt',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-fire',
                    n: 'Fire',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-wand-magic-sparkles',
                    n: 'Magic',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-trophy',
                    n: 'Trophy',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-medal',
                    n: 'Medal',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-certificate',
                    n: 'Certificate',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-circle-check',
                    n: 'Checkmark',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-download',
                    n: 'Download',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-upload',
                    n: 'Upload',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-eye',
                    n: 'Eye',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-clock',
                    n: 'Clock',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-calendar',
                    n: 'Calendar',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-bookmark',
                    n: 'Bookmark',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-flag',
                    n: 'Flag',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-bell',
                    n: 'Bell',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-layer-group',
                    n: 'Layers',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-puzzle-piece',
                    n: 'Puzzle',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-cubes',
                    n: 'Cubes',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-fingerprint',
                    n: 'Fingerprint',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-arrow-right',
                    n: 'Arrow Right',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-check',
                    n: 'Check',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-location-dot',
                    n: 'Location',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-paper-plane',
                    n: 'Paper Plane',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-seedling',
                    n: 'Seedling',
                    cat: 'ui'
                },
                {
                    c: 'fa-solid fa-leaf',
                    n: 'Leaf',
                    cat: 'ui'
                },

                // Content / Media
                {
                    c: 'fa-solid fa-pen',
                    n: 'Pen',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-pencil',
                    n: 'Pencil',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-palette',
                    n: 'Palette',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-paint-brush',
                    n: 'Paint Brush',
                    cat: 'media'
                }, // Note: fa-paintbrush is the canonical name
                {
                    c: 'fa-solid fa-camera',
                    n: 'Camera',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-image',
                    n: 'Image',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-images',
                    n: 'Images',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-video',
                    n: 'Video',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-music',
                    n: 'Music',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-book',
                    n: 'Book',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-book-open',
                    n: 'Book Open',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-newspaper',
                    n: 'Newspaper',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-comment',
                    n: 'Comment',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-comments',
                    n: 'Comments',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-envelope',
                    n: 'Envelope',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-phone',
                    n: 'Phone',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-headset',
                    n: 'Headset',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-podcast',
                    n: 'Podcast',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-blog',
                    n: 'Blog',
                    cat: 'media'
                },
                {
                    c: 'fa-solid fa-rss',
                    n: 'RSS',
                    cat: 'media'
                },

                // Brands
                {
                    c: 'fa-brands fa-php',
                    n: 'PHP',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-laravel',
                    n: 'Laravel',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-js',
                    n: 'JavaScript',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-css3-alt',
                    n: 'CSS3',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-html5',
                    n: 'HTML5',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-vuejs',
                    n: 'Vue.js',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-react',
                    n: 'React',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-angular',
                    n: 'Angular',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-node-js',
                    n: 'Node.js',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-python',
                    n: 'Python',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-java',
                    n: 'Java',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-git-alt',
                    n: 'Git',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-github',
                    n: 'GitHub',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-docker',
                    n: 'Docker',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-aws',
                    n: 'AWS',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-bootstrap',
                    n: 'Bootstrap',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-wordpress',
                    n: 'WordPress',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-shopify',
                    n: 'Shopify',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-figma',
                    n: 'Figma',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-linux',
                    n: 'Linux',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-android',
                    n: 'Android',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-apple',
                    n: 'Apple',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-windows',
                    n: 'Windows',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-google',
                    n: 'Google',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-whatsapp',
                    n: 'WhatsApp',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-instagram',
                    n: 'Instagram',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-linkedin-in',
                    n: 'LinkedIn',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-twitter',
                    n: 'Twitter',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-facebook-f',
                    n: 'Facebook',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-youtube',
                    n: 'YouTube',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-sass',
                    n: 'Sass',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-npm',
                    n: 'NPM',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-stripe',
                    n: 'Stripe',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-slack',
                    n: 'Slack',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-dribbble',
                    n: 'Dribbble',
                    cat: 'brand'
                },
                {
                    c: 'fa-brands fa-behance',
                    n: 'Behance',
                    cat: 'brand'
                },
            ],
            get filteredIcons() {
                let result = this.icons;
                if (this.activeCategory !== 'all') {
                    result = result.filter(i => i.cat === this.activeCategory);
                }
                if (this.search) {
                    const s = this.search.toLowerCase();
                    result = result.filter(i => i.n.toLowerCase().includes(s) || i.c.toLowerCase().includes(s));
                }
                return result;
            },
            select(cls) {
                this.selected = cls;
                this.open = false;
                this.search = '';
            },
            togglePicker() {
                this.open = !this.open;
                if (this.open) {
                    this.$nextTick(() => this.$refs.searchInput?.focus());
                }
            },
        };
    }
</script>
@endpush
@endonce