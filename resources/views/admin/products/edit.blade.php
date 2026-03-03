@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-2">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Kembali ke Produk
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Edit Produk: {{ $product->title }}</h1>
</div>

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Basic Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-900">Informasi Dasar</h2>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $product->title) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm font-mono">
                    @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="6" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ old('description', $product->description) }}</textarea>
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
                    <input type="text" name="title_en" id="title_en" value="{{ old('title_en', $product->title_en) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="English title...">
                    @error('title_en') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description_en" class="block text-sm font-medium text-gray-700 mb-1">Description (EN)</label>
                    <textarea name="description_en" id="description_en" rows="6" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="English description...">{{ old('description_en', $product->description_en) }}</textarea>
                    @error('description_en') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div x-data="dynamicList('features_en', @js(old('features_en', $product->features_en ?? [''])))">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Features (EN)</label>
                    <template x-for="(item, index) in items" :key="index">
                        <div class="flex gap-2 mb-2">
                            <input type="text" :name="fieldName + '[' + index + ']'" x-model="items[index]" class="flex-1 rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="e.g. Multi-role user management">
                            <button type="button" @click="remove(index)" class="px-2 py-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" x-show="items.length > 1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="add()" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 mt-1">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Add Feature
                    </button>
                </div>
            </div>

            {{-- Pricing & Details --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-900">Harga & Detail</h2>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga (Rupiah) <span class="text-red-500">*</span></label>
                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required min="0" step="1000" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="version" class="block text-sm font-medium text-gray-700 mb-1">Versi</label>
                        <input type="text" name="version" id="version" value="{{ old('version', $product->version) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('version') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="demo_url" class="block text-sm font-medium text-gray-700 mb-1">URL Demo</label>
                    <input type="url" name="demo_url" id="demo_url" value="{{ old('demo_url', $product->demo_url) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="https://demo.example.com">
                    @error('demo_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Dynamic Tech Stack --}}
                <div x-data="dynamicList('tech_stack', @js(old('tech_stack', $product->tech_stack ?? [''])))">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tech Stack</label>
                    <template x-for="(item, index) in items" :key="index">
                        <div class="flex gap-2 mb-2">
                            <input type="text" :name="fieldName + '[' + index + ']'" x-model="items[index]" class="flex-1 rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <button type="button" @click="remove(index)" class="px-2 py-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" x-show="items.length > 1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="add()" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 mt-1">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Teknologi
                    </button>
                </div>

                {{-- Dynamic Features --}}
                <div x-data="dynamicList('features', @js(old('features', $product->features ?? [''])))">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fitur Utama</label>
                    <template x-for="(item, index) in items" :key="index">
                        <div class="flex gap-2 mb-2">
                            <input type="text" :name="fieldName + '[' + index + ']'" x-model="items[index]" class="flex-1 rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <button type="button" @click="remove(index)" class="px-2 py-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" x-show="items.length > 1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="add()" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 mt-1">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Fitur
                    </button>
                </div>
            </div>

            {{-- Files & Images --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-900">File & Gambar</h2>

                {{-- Thumbnail --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                    @if ($product->thumbnail)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="Thumbnail" class="w-32 h-24 rounded-lg object-cover">
                    </div>
                    @endif
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti thumbnail.</p>
                    @error('thumbnail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Source Code File --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">File Source Code (ZIP/RAR)</label>
                    @if ($product->file_path)
                    <div class="mb-2 flex items-center gap-2 text-sm text-gray-500">
                        <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        File sudah diupload
                    </div>
                    @endif
                    <input type="file" name="file_path" id="file_path" accept=".zip,.rar" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti file.</p>
                    @error('file_path') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Existing Images --}}
                @if ($product->images->count())
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Screenshot Saat Ini</label>
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                        @foreach ($product->images->sortBy('order') as $image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Screenshot" class="w-full h-24 rounded-lg object-cover">
                            <form action="{{ route('admin.products.images.destroy', [$product, $image]) }}" method="POST" class="absolute top-1 right-1" onsubmit="return confirm('Hapus gambar ini?')">
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

                {{-- Add More Screenshots --}}
                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Tambah Screenshot</label>
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
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $product->meta_title) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" maxlength="255">
                    @error('meta_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" maxlength="500">{{ old('meta_description', $product->meta_description) }}</textarea>
                    @error('meta_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="meta_title_en" class="block text-sm font-medium text-gray-700 mb-1">Meta Title (EN)</label>
                    <input type="text" name="meta_title_en" id="meta_title_en" value="{{ old('meta_title_en', $product->meta_title_en) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" maxlength="255" placeholder="English meta title...">
                    @error('meta_title_en') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="meta_description_en" class="block text-sm font-medium text-gray-700 mb-1">Meta Description (EN)</label>
                    <textarea name="meta_description_en" id="meta_description_en" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" maxlength="500" placeholder="English meta description...">{{ old('meta_description_en', $product->meta_description_en) }}</textarea>
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
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="is_active" class="text-sm text-gray-700">Produk aktif (tampil di katalog)</label>
                </div>

                <div class="text-xs text-gray-400 mb-4 space-y-1">
                    <p>Download: {{ $product->download_count }}x</p>
                    <p>Dibuat: {{ $product->created_at->translatedFormat('d M Y H:i') }}</p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('admin.products.index') }}" class="flex-1 px-4 py-2.5 text-center text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</a>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">Perbarui</button>
                </div>
            </div>

            {{-- Category --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Kategori <span class="text-red-500">*</span></h2>
                @error('category_id') <p class="text-red-500 text-xs mb-2">{{ $message }}</p> @enderror

                <select name="category_id" id="category_id" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tags --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Tag</h2>

                @php $selectedTags = old('tags', $product->tags->pluck('id')->toArray()); @endphp
                @forelse ($tags as $tag)
                <label class="flex items-center gap-2 py-1.5">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm text-gray-700">{{ $tag->name }}</span>
                </label>
                @empty
                <p class="text-sm text-gray-400">Belum ada tag.</p>
                @endforelse
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    function dynamicList(name, initial) {
        return {
            fieldName: name,
            items: initial && initial.length ? initial : [''],
            add() {
                this.items.push('');
            },
            remove(i) {
                this.items.splice(i, 1);
            }
        }
    }
</script>
@endpush
@endsection