@extends('layouts.admin')

@section('title', 'Order')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Order & Transaksi</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola semua pesanan pembelian produk source code.</p>
    </div>
</div>

{{-- Filter Status --}}
<div class="flex gap-2 mb-4">
    <a href="{{ route('admin.orders.index') }}" class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ !request('status') ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 border border-gray-300 hover:bg-gray-50' }}">
        Semua
    </a>
    @foreach (['pending' => 'Pending', 'paid' => 'Paid', 'expired' => 'Expired'] as $value => $label)
    <a href="{{ route('admin.orders.index', ['status' => $value]) }}" class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request('status') === $value ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 border border-gray-300 hover:bg-gray-50' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembeli</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Nominal</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm font-mono font-medium text-gray-900">{{ $order->order_number }}</td>
                <td class="px-6 py-4">
                    <p class="text-sm font-medium text-gray-900">{{ $order->buyer_name }}</p>
                    <p class="text-xs text-gray-500">{{ $order->buyer_email }}</p>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $order->product?->title ?? '-' }}</td>
                <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">{{ $order->formatted_amount }}</td>
                <td class="px-6 py-4 text-center">
                    @switch($order->status)
                    @case('pending')
                    <span class="inline-flex px-2.5 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                    @break
                    @case('paid')
                    <span class="inline-flex px-2.5 py-0.5 text-xs font-medium bg-green-100 text-green-800 rounded-full">Paid</span>
                    @break
                    @case('expired')
                    <span class="inline-flex px-2.5 py-0.5 text-xs font-medium bg-red-100 text-red-800 rounded-full">Expired</span>
                    @break
                    @endswitch
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->translatedFormat('d M Y H:i') }}</td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                    <p class="text-sm">Belum ada order.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @include('admin.components.pagination', ['paginator' => $orders])
</div>
@endsection