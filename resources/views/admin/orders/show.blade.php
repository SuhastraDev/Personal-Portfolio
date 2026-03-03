@extends('layouts.admin')

@section('title', 'Detail Order')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-2">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Kembali ke Order
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Order: {{ $order->order_number }}</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Order Detail --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Buyer Info --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pembeli</h2>
            <dl class="grid grid-cols-2 gap-4">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Nama</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $order->buyer_name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $order->buyer_email }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">No. WhatsApp</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        @if ($order->buyer_phone)
                        {{ $order->buyer_phone }}
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->buyer_phone) }}" target="_blank" class="ml-1 text-green-600 hover:text-green-700 text-xs">(Chat WA)</a>
                        @else
                        -
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        {{-- Product Info --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Produk</h2>
            @if ($order->product)
            <div class="flex items-center gap-4">
                @if ($order->product->thumbnail)
                <img src="{{ asset('storage/' . $order->product->thumbnail) }}" alt="{{ $order->product->title }}" class="w-20 h-15 rounded-lg object-cover">
                @endif
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $order->product->title }}</p>
                    <p class="text-sm text-gray-500">{{ $order->product->category?->name ?? '-' }}</p>
                </div>
            </div>
            @else
            <p class="text-sm text-gray-400">Produk telah dihapus.</p>
            @endif
        </div>

        {{-- Transaction Info --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Transaksi</h2>
            <dl class="grid grid-cols-2 gap-4">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Nomor Order</dt>
                    <dd class="mt-1 text-sm font-mono text-gray-900">{{ $order->order_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Nominal</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $order->formatted_amount }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Metode Pembayaran</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $order->payment_method ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Referensi Pembayaran</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $order->payment_ref ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Tanggal Order</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $order->created_at->translatedFormat('d M Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Tanggal Bayar</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $order->paid_at?->translatedFormat('d M Y H:i') ?? '-' }}</dd>
                </div>
            </dl>

            @if ($order->notes)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <dt class="text-xs font-medium text-gray-500 uppercase mb-1">Catatan</dt>
                <dd class="text-sm text-gray-700">{{ $order->notes }}</dd>
            </div>
            @endif
        </div>

        {{-- Download Info --}}
        @if ($order->status === 'paid')
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Download</h2>
            <dl class="grid grid-cols-2 gap-4">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Download Token</dt>
                    <dd class="mt-1 text-xs font-mono text-gray-700 break-all">{{ $order->download_token ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Jumlah Download</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $order->download_count }}/2</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Expired</dt>
                    <dd class="mt-1 text-sm {{ $order->download_expires_at?->isPast() ? 'text-red-600' : 'text-gray-900' }}">
                        {{ $order->download_expires_at?->translatedFormat('d M Y H:i') ?? '-' }}
                        @if ($order->download_expires_at?->isPast())
                        <span class="text-xs text-red-500">(Kedaluwarsa)</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status Download</dt>
                    <dd class="mt-1">
                        @if ($order->isDownloadable())
                        <span class="inline-flex px-2.5 py-0.5 text-xs font-medium bg-green-100 text-green-800 rounded-full">Aktif</span>
                        @else
                        <span class="inline-flex px-2.5 py-0.5 text-xs font-medium bg-red-100 text-red-800 rounded-full">Tidak Aktif</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
        @endif
    </div>

    {{-- Sidebar Actions --}}
    <div class="space-y-6">
        {{-- Status --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Status Order</h2>

            <div class="mb-4">
                @switch($order->status)
                @case('pending')
                <span class="inline-flex px-3 py-1 text-sm font-medium bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                @break
                @case('paid')
                <span class="inline-flex px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded-full">Paid</span>
                @break
                @case('expired')
                <span class="inline-flex px-3 py-1 text-sm font-medium bg-red-100 text-red-800 rounded-full">Expired</span>
                @break
                @case('cancelled')
                <span class="inline-flex px-3 py-1 text-sm font-medium bg-gray-100 text-gray-800 rounded-full">Cancelled</span>
                @break
                @endswitch
            </div>

            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Ubah Status</label>
                <select name="status" id="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm mb-3">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="expired" {{ $order->status === 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="w-full px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">Update Status</button>
            </form>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>

            @if ($order->buyer_phone)
            @php
            $waNumber = preg_replace('/[^0-9]/', '', $order->buyer_phone);
            $waMessage = urlencode("Halo {$order->buyer_name}, terima kasih sudah memesan *{$order->product?->title}*.\n\nOrder: {$order->order_number}\nNominal: {$order->formatted_amount}\n\n");
            @endphp
            <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" target="_blank" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm mb-3">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
                Follow-up via WhatsApp
            </a>
            @endif

            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus order ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-red-600 border border-red-300 hover:bg-red-50 text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                    Hapus Order
                </button>
            </form>
        </div>
    </div>
</div>
@endsection