@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Produk Source Code</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola produk source code yang dijual di marketplace.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Tambah Produk
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Download</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($products as $product)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        @if ($product->thumbnail)
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->title }}" class="w-16 h-12 rounded-lg object-cover">
                        @else
                        <div class="w-16 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                            </svg>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $product->title }}</p>
                            <div class="flex flex-wrap gap-1 mt-0.5">
                                @foreach ($product->tags as $tag)
                                <span class="inline-flex px-1.5 py-0.5 text-[10px] font-medium bg-slate-100 text-slate-600 rounded">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $product->category?->name ?? '-' }}</td>
                <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">{{ $product->formatted_price }}</td>
                <td class="px-6 py-4 text-center">
                    @if ($product->is_active)
                    <span class="inline-flex px-2.5 py-0.5 text-xs font-medium bg-green-100 text-green-800 rounded-full">Aktif</span>
                    @else
                    <span class="inline-flex px-2.5 py-0.5 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">Nonaktif</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center text-sm text-gray-500">{{ $product->download_count }}</td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            Edit
                        </a>
                        @include('admin.components.delete-button', ['route' => route('admin.products.destroy', $product), 'label' => $product->title])
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                    <p class="text-sm">Belum ada produk.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @include('admin.components.pagination', ['paginator' => $products])
</div>
@endsection