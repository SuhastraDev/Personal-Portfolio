@extends('layouts.admin')

@section('title', 'Edit Portfolio')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.portfolios.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-2">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Kembali ke Portfolio
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Edit Portfolio: {{ $portfolio->title }}</h1>
</div>

<form action="{{ route('admin.portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Basic Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-900">Informasi Dasar</h2>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $portfolio->title) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $portfolio->slug) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm font-mono">
                    @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="6" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ old('description', $portfolio->description) }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- English Translation --}}
            <div class="bg-white rounded-xl shadow-sm border border-blue-200 p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <span class="text-blue-500">🌐</span> Terjemahan (English)
                    <span class="text-xs font-normal text-gray-400">— Opsional, untuk versi bahasa Inggris</span>
                </h2>

                <div>
                    <label for="title_en" class="block text-sm font-medium text-gray-700 mb-1">Title (EN)</label>
                    <input type="text" name="title_en" id="title_en" value="{{ old('title_en', $portfolio->title_en) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="English title...">
                    @error('title_en') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description_en" class="block text-sm font-medium text-gray-700 mb-1">Description (EN)</label>
                    <textarea name="description_en" id="description_en" rows="6" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="English description...">{{ old('description_en', $portfolio->description_en) }}</textarea>
                    @error('description_en') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Project Details --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-900">Detail Proyek</h2>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="client_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Klien</label>
                        <input type="text" name="client_name" id="client_name" value="{{ old('client_name', $portfolio->client_name) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('client_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="completion_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                        <input type="date" name="completion_date" id="completion_date" value="{{ old('completion_date', $portfolio->completion_date?->format('Y-m-d')) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('completion_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="url" class="block text-sm font-medium text-gray-700 mb-1">URL Proyek</label>
                    <input type="url" name="url" id="url" value="{{ old('url', $portfolio->url) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="https://example.com">
                    @error('url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Dynamic Tech Stack --}}
                <div x-data="techStack()" x-init="init()">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tech Stack</label>
                    <template x-for="(item, index) in items" :key="index">
                        <div class="flex gap-2 mb-2">
                            <input type="text" :name="'tech_stack[' + index + ']'" x-model="items[index]" class="flex-1 rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="contoh: Laravel, Vue.js">
                            <button type="button" @click="removeItem(index)" class="px-2 py-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" x-show="items.length > 1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="addItem()" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 mt-1">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Teknologi
                    </button>
                    @error('tech_stack') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Images --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-900">Gambar</h2>

                {{-- Current Thumbnail --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                    @if ($portfolio->thumbnail)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $portfolio->thumbnail) }}" alt="Current thumbnail" class="w-32 h-24 rounded-lg object-cover">
                    </div>
                    @endif
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti thumbnail.</p>
                    @error('thumbnail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Existing Images --}}
                @if ($portfolio->images->count())
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                        @foreach ($portfolio->images->sortBy('order') as $image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Portfolio image" class="w-full h-24 rounded-lg object-cover">
                            <form action="{{ route('admin.portfolios.images.destroy', [$portfolio, $image]) }}" method="POST" class="absolute top-1 right-1" onsubmit="return confirm('Hapus gambar ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity shadow-sm hover:bg-red-600">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Add More Images --}}
                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Tambah Gambar</label>
                    <input type="file" name="images[]" id="images" accept="image/*" multiple class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-gray-400 mt-1">Maks 10 gambar, masing-masing maks 5MB.</p>
                    @error('images') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @error('images.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- SEO --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-900">SEO</h2>

                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $portfolio->meta_title) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" maxlength="255">
                    @error('meta_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" maxlength="500">{{ old('meta_description', $portfolio->meta_description) }}</textarea>
                    @error('meta_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="meta_title_en" class="block text-sm font-medium text-gray-700 mb-1">Meta Title (EN)</label>
                    <input type="text" name="meta_title_en" id="meta_title_en" value="{{ old('meta_title_en', $portfolio->meta_title_en) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" maxlength="255" placeholder="English meta title...">
                    @error('meta_title_en') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="meta_description_en" class="block text-sm font-medium text-gray-700 mb-1">Meta Description (EN)</label>
                    <textarea name="meta_description_en" id="meta_description_en" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" maxlength="500" placeholder="English meta description...">{{ old('meta_description_en', $portfolio->meta_description_en) }}</textarea>
                    @error('meta_description_en') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Publish --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Publikasi</h2>

                <div class="flex items-center gap-2 mb-4">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $portfolio->is_featured) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="is_featured" class="text-sm text-gray-700">Tandai sebagai Featured</label>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('admin.portfolios.index') }}" class="flex-1 px-4 py-2.5 text-center text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</a>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">Perbarui</button>
                </div>
            </div>

            {{-- Categories --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Kategori <span class="text-red-500">*</span></h2>
                @error('categories') <p class="text-red-500 text-xs mb-2">{{ $message }}</p> @enderror

                @php $selectedCategories = old('categories', $portfolio->categories->pluck('id')->toArray()); @endphp
                @forelse ($categories as $category)
                <label class="flex items-center gap-2 py-1.5">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm text-gray-700">{{ $category->name }}</span>
                </label>
                @empty
                <p class="text-sm text-gray-400">Belum ada kategori. <a href="{{ route('admin.portfolio-categories.create') }}" class="text-indigo-600 hover:underline">Buat kategori</a></p>
                @endforelse
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    function techStack() {
        return {
            items: [],
            init() {
                const old = @json(old('tech_stack', $portfolio - > tech_stack ?? ['']));
                this.items = old.length ? old : [''];
            },
            addItem() {
                this.items.push('');
            },
            removeItem(index) {
                this.items.splice(index, 1);
            }
        }
    }
</script>
@endpush
@endsection