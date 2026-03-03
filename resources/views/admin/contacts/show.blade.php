@extends('layouts.admin')

@section('title', 'Detail Pesan')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-2">
        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Kembali ke Pesan
    </a>
    <h1 class="text-2xl font-bold text-gray-900">Detail Pesan</h1>
</div>

<div class="max-w-3xl space-y-6">
    {{-- Pengirim Info --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-start justify-between">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center shrink-0">
                    <span class="text-lg font-bold text-indigo-600">{{ strtoupper(substr($contact->name, 0, 1)) }}</span>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ $contact->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $contact->email }}</p>
                    @if($contact->phone)
                    <p class="text-sm text-gray-500 mt-0.5">{{ $contact->phone }}</p>
                    @endif
                </div>
            </div>
            <div class="text-right">
                @if($contact->is_read)
                <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 rounded">Dibaca</span>
                @else
                <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium bg-red-100 text-red-700 rounded">Belum Dibaca</span>
                @endif
                <p class="text-xs text-gray-400 mt-1">{{ $contact->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
    </div>

    {{-- Pesan --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="mb-4">
            <div class="flex items-center gap-3 mb-3">
                <h3 class="text-base font-semibold text-gray-900">{{ $contact->subject }}</h3>
                @if($contact->service_type)
                <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium bg-indigo-100 text-indigo-700 rounded">{{ $contact->service_type }}</span>
                @endif
            </div>
            <div class="prose prose-sm max-w-none text-gray-700">
                {!! nl2br(e($contact->message)) !!}
            </div>
        </div>
    </div>

    {{-- Aksi --}}
    <div class="flex items-center gap-3">
        @if($contact->phone)
        @php
        $waNumber = preg_replace('/[^0-9]/', '', $contact->phone);
        if (str_starts_with($waNumber, '0')) {
        $waNumber = '62' . substr($waNumber, 1);
        }
        $waMessage = urlencode("Halo {$contact->name}, terima kasih sudah menghubungi Suhastra Dev. Saya sudah menerima pesan Anda mengenai \"{$contact->subject}\". ");
        @endphp
        <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" target="_blank" class="inline-flex items-center px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
            Balas via WhatsApp
        </a>
        @endif

        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
            </svg>
            Balas via Email
        </a>

        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan dari {{ $contact->name }}?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-white border border-red-300 text-red-600 hover:bg-red-50 text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
                Hapus
            </button>
        </form>
    </div>
</div>
@endsection