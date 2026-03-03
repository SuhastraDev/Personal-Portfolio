@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
{{-- Balance Card --}}
<div class="mb-8">
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-lg p-6 sm:p-8 text-white relative overflow-hidden">
        {{-- Decoration --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-40 h-40 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/4"></div>

        <div class="relative z-10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-5 h-5 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3" />
                        </svg>
                        <p class="text-sm font-medium text-indigo-200">Saldo / Total Pendapatan</p>
                    </div>
                    <p class="text-3xl sm:text-4xl font-bold tracking-tight">Rp {{ number_format($balance['total'], 0, ',', '.') }}</p>
                    <div class="flex items-center gap-4 mt-3">
                        <div class="flex items-center gap-1.5">
                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                            <span class="text-sm text-indigo-100">Bulan ini: <strong>Rp {{ number_format($balance['thisMonth'], 0, ',', '.') }}</strong></span>
                        </div>
                        <span class="text-indigo-300">·</span>
                        <span class="text-sm text-indigo-100">{{ $balance['paidCount'] }} transaksi sukses</span>
                    </div>
                </div>

                <div class="flex flex-col gap-2 sm:items-end">
                    <a href="https://{{ config('midtrans.is_production') ? 'dashboard' : 'dashboard.sandbox' }}.midtrans.com" target="_blank" rel="noopener"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/15 hover:bg-white/25 backdrop-blur rounded-lg text-sm font-medium transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                        Dashboard Midtrans
                    </a>
                    <p class="text-xs text-indigo-300">Cek saldo aktual di Midtrans</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    {{-- Portfolio --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Portfolio</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['portfolios'] }}</p>
            </div>
            <div class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v13.5A1.5 1.5 0 003.75 21z" />
                </svg>
            </div>
        </div>
        <a href="{{ route('admin.portfolios.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 mt-2 inline-block">Lihat semua &rarr;</a>
    </div>

    {{-- Produk Aktif --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Produk Aktif</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['products'] }}</p>
            </div>
            <div class="w-12 h-12 bg-emerald-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
            </div>
        </div>
        <a href="{{ route('admin.products.index') }}" class="text-xs text-emerald-600 hover:text-emerald-800 mt-2 inline-block">Lihat semua &rarr;</a>
    </div>

    {{-- Total Order --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Order</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['orders'] }}</p>
            </div>
            <div class="w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121 0 2.09-.773 2.34-1.867l1.58-6.921H5.256M8.25 20.25a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM17.25 20.25a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                </svg>
            </div>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="text-xs text-amber-600 hover:text-amber-800 mt-2 inline-block">Lihat semua &rarr;</a>
    </div>

    {{-- Pesan Belum Dibaca --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Pesan Baru</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['unreadMessages'] }}</p>
            </div>
            <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg>
            </div>
        </div>
        <a href="{{ route('admin.contacts.index', ['filter' => 'unread']) }}" class="text-xs text-red-600 hover:text-red-800 mt-2 inline-block">Lihat pesan &rarr;</a>
    </div>

    {{-- Order Pending --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Order Pending</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['pendingOrders'] }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="text-xs text-yellow-600 hover:text-yellow-800 mt-2 inline-block">Lihat pending &rarr;</a>
    </div>

    {{-- Total Pendapatan --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Pendapatan</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-teal-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                </svg>
            </div>
        </div>
        <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}" class="text-xs text-teal-600 hover:text-teal-800 mt-2 inline-block">Lihat paid &rarr;</a>
    </div>
</div>

{{-- Recent Content --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Recent Messages --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-base font-semibold text-gray-900">Pesan Terbaru</h2>
            <a href="{{ route('admin.contacts.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Lihat semua</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentMessages as $message)
            <a href="{{ route('admin.contacts.show', $message) }}" class="block px-6 py-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                        <span class="text-xs font-medium text-gray-600">{{ substr($message->name, 0, 1) }}</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $message->name }}</p>
                            <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-600 truncate">{{ $message->subject }}</p>
                        @if(!$message->is_read)
                        <span class="inline-flex items-center px-1.5 py-0.5 text-xs font-medium bg-red-100 text-red-700 rounded mt-1">Belum dibaca</span>
                        @endif
                    </div>
                </div>
            </a>
            @empty
            <div class="px-6 py-8 text-center text-sm text-gray-500">Belum ada pesan masuk.</div>
            @endforelse
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-base font-semibold text-gray-900">Order Terbaru</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Lihat semua</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentOrders as $order)
            <a href="{{ route('admin.orders.show', $order) }}" class="block px-6 py-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center justify-between mb-1">
                    <p class="text-sm font-medium text-gray-900">{{ $order->buyer_name }}</p>
                    <span class="text-sm font-semibold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">{{ $order->order_number }} &middot; {{ $order->product->title ?? '-' }}</p>
                    @php
                    $statusColors = [
                    'pending' => 'bg-yellow-100 text-yellow-700',
                    'paid' => 'bg-green-100 text-green-700',
                    'expired' => 'bg-red-100 text-red-700',
                    ];
                    @endphp
                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </a>
            @empty
            <div class="px-6 py-8 text-center text-sm text-gray-500">Belum ada order.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection