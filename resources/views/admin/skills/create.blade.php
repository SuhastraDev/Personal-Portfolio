@extends('layouts.admin')

@section('title', 'Tambah Skill')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.skills.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-2">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Kembali ke Skills
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Tambah Skill</h1>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 max-w-2xl">
    <form action="{{ route('admin.skills.store') }}" method="POST">
        @csrf
        <div class="p-6 space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Skill <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="contoh: Laravel">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            @include('admin.partials.icon-picker', ['name' => 'icon', 'value' => old('icon', '')])

            <div>
                <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Level / Persentase (0-100) <span class="text-red-500">*</span></label>
                <input type="number" name="level" id="level" value="{{ old('level', 80) }}" min="0" max="100" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @error('level') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                <input type="number" name="order" id="order" value="{{ old('order', 0) }}" min="0" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                <p class="text-xs text-gray-400 mt-1">Semakin kecil angka, semakin atas urutan.</p>
                @error('order') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-xl flex justify-end gap-3">
            <a href="{{ route('admin.skills.index') }}" class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</a>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">Simpan Skill</button>
        </div>
    </form>
</div>
@endsection