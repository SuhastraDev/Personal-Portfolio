@extends('layouts.admin')

@section('title', 'Edit Testimoni')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.testimonials.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-2">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Kembali ke Testimoni
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Edit Testimoni: {{ $testimonial->client_name }}</h1>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 max-w-2xl">
    <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="p-6 space-y-4">
            <div>
                <label for="client_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Klien <span class="text-red-500">*</span></label>
                <input type="text" name="client_name" id="client_name" value="{{ old('client_name', $testimonial->client_name) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @error('client_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="client_role" class="block text-sm font-medium text-gray-700 mb-1">Jabatan / Perusahaan</label>
                <input type="text" name="client_role" id="client_role" value="{{ old('client_role', $testimonial->client_role) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="contoh: CEO, PT Maju Jaya">
                @error('client_role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Isi Testimoni <span class="text-red-500">*</span></label>
                <textarea name="content" id="content" rows="4" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ old('content', $testimonial->content) }}</textarea>
                @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating <span class="text-red-500">*</span></label>
                <select name="rating" id="rating" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" {{ old('rating', $testimonial->rating) == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                    @endfor
                </select>
                @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1">Foto Klien</label>
                @if ($testimonial->avatar)
                <div class="mb-2 flex items-center gap-3">
                    <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->client_name }}" class="w-16 h-16 rounded-full object-cover">
                    <span class="text-xs text-gray-400">Foto saat ini</span>
                </div>
                @endif
                <input type="file" name="avatar" id="avatar" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti foto.</p>
                @error('avatar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="is_active" class="text-sm text-gray-700">Tampilkan di website</label>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-xl flex justify-end gap-3">
            <a href="{{ route('admin.testimonials.index') }}" class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</a>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">Perbarui Testimoni</button>
        </div>
    </form>
</div>
@endsection