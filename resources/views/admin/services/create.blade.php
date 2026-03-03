@extends('layouts.admin')

@section('title', 'Tambah Layanan')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.services.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-2">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Kembali ke Layanan
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Tambah Layanan</h1>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 max-w-2xl">
    <form action="{{ route('admin.services.store') }}" method="POST">
        @csrf
        <div class="p-6 space-y-4">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Layanan <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="contoh: Pembuatan Website Custom">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            @include('admin.partials.icon-picker', ['name' => 'icon', 'value' => old('icon', '')])

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="5" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="Jelaskan detail layanan yang ditawarkan...">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- English Translation --}}
            <div class="pt-4 mt-4 border-t border-blue-200">
                <h3 class="text-sm font-semibold text-gray-900 flex items-center gap-2 mb-4">
                    <span class="text-blue-500">🌐</span> Terjemahan (English)
                    <span class="text-xs font-normal text-gray-400">— Opsional</span>
                </h3>

                <div class="space-y-4">
                    <div>
                        <label for="title_en" class="block text-sm font-medium text-gray-700 mb-1">Title (EN)</label>
                        <input type="text" name="title_en" id="title_en" value="{{ old('title_en') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="English title...">
                        @error('title_en') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description_en" class="block text-sm font-medium text-gray-700 mb-1">Description (EN)</label>
                        <textarea name="description_en" id="description_en" rows="5" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="English description...">{{ old('description_en') }}</textarea>
                        @error('description_en') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="price_start" class="block text-sm font-medium text-gray-700 mb-1">Harga Mulai (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price_start" id="price_start" value="{{ old('price_start', 0) }}" min="0" step="1000" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="500000">
                    @error('price_start') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="price_end" class="block text-sm font-medium text-gray-700 mb-1">Harga Sampai (Rp)</label>
                    <input type="number" name="price_end" id="price_end" value="{{ old('price_end') }}" min="0" step="1000" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="2000000">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika harga fleksibel / negotiable.</p>
                    @error('price_end') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-6">
                <div class="flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <label for="is_active" class="ml-2 text-sm text-gray-700">Aktif</label>
                </div>
            </div>

            <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                <input type="number" name="order" id="order" value="{{ old('order', 0) }}" min="0" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                <p class="text-xs text-gray-400 mt-1">Semakin kecil angka, semakin atas urutan.</p>
                @error('order') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-xl flex justify-end gap-3">
            <a href="{{ route('admin.services.index') }}" class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</a>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">Simpan Layanan</button>
        </div>
    </form>
</div>
@endsection