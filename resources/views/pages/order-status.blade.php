@extends('layouts.app')

@section('title', __('Cek Status Pesanan'))
@section('meta_title', __('Cek Status Pesanan') . ' — SuhastraDev')

@section('content')
<section class="bg-gradient-to-br from-dark-950 via-dark-900 to-primary-950 pt-32 pb-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-grid-pattern bg-grid"></div>
    </div>
    <div class="absolute top-1/4 right-10 w-64 h-64 bg-primary-500/10 rounded-full blur-[80px]"></div>
    <div class="absolute top-20 right-20 w-20 h-20 border border-white/10 rounded-2xl rotate-12 animate-float hidden sm:block"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur-md text-primary-300 text-xs font-semibold rounded-full uppercase tracking-wider mb-5 border border-white/10 shadow-sm" data-aos="fade-up">
                <i class="fa-solid fa-magnifying-glass"></i> {{ __('Cek Pesanan') }}
            </span>
            <h1 class="font-heading text-4xl sm:text-5xl font-bold text-white mb-4" data-aos="fade-up" data-aos-delay="100">{{ __('Cek Status Pesanan') }}</h1>
            <p class="text-dark-300 max-w-xl mx-auto text-lg" data-aos="fade-up" data-aos-delay="150">{{ __('Masukkan nomor order dan email yang digunakan saat pembelian.') }}</p>
        </div>
    </div>
</section>

<section class="py-20 bg-white" x-data="orderLookup()">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:p-8" data-aos="fade-up">
            <h2 class="font-heading text-lg font-bold text-dark-900 mb-6 text-center flex items-center justify-center gap-2">
                <span class="w-8 h-8 bg-primary-50 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-receipt text-xs text-primary-600"></i>
                </span>
                {{ __('Cari Pesanan Anda') }}
            </h2>

            <div class="space-y-4">
                <div>
                    <label for="order_number" class="block text-sm font-medium text-dark-700 mb-1.5">{{ __('Nomor Order') }} <span class="text-red-500">*</span></label>
                    <input type="text" id="order_number" x-model="form.order_number" required
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 text-sm py-3"
                        placeholder="INV-20250101-001">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-dark-700 mb-1.5">{{ __('Email') }} <span class="text-red-500">*</span></label>
                    <input type="email" id="email" x-model="form.email" required
                        class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 text-sm py-3"
                        placeholder="contoh@email.com">
                </div>

                <button @click="lookup()" :disabled="loading"
                    class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-500 hover:to-indigo-500 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg shadow-primary-600/25 hover:shadow-xl hover:shadow-primary-600/40 disabled:opacity-50 disabled:cursor-not-allowed">
                    <template x-if="!loading">
                        <span class="flex items-center"><i class="fa-solid fa-search mr-2"></i> {{ __('Cari Pesanan') }}</span>
                    </template>
                    <template x-if="loading">
                        <span class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            {{ __('Mencari...') }}
                        </span>
                    </template>
                </button>

                <div x-show="errorMessage" x-text="errorMessage"
                    class="p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700 text-center"></div>
            </div>
        </div>

        {{-- Result --}}
        <template x-if="order">
            <div class="mt-8 bg-white rounded-2xl border border-gray-100 shadow-lg overflow-hidden" data-aos="fade-up">
                {{-- Status Banner --}}
                <div :class="{
                    'bg-green-50 border-green-100': order.status === 'paid',
                    'bg-yellow-50 border-yellow-100': order.status === 'pending',
                    'bg-red-50 border-red-100': order.status === 'expired'
                }" class="border-b px-6 py-4 flex items-center gap-3">
                    <div :class="{
                        'bg-green-500': order.status === 'paid',
                        'bg-yellow-500': order.status === 'pending',
                        'bg-red-500': order.status === 'expired'
                    }" class="w-10 h-10 rounded-full flex items-center justify-center shrink-0">
                        <i :class="{
                            'fa-check': order.status === 'paid',
                            'fa-clock': order.status === 'pending',
                            'fa-xmark': order.status === 'expired'
                        }" class="fa-solid text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold" :class="{
                            'text-green-800': order.status === 'paid',
                            'text-yellow-800': order.status === 'pending',
                            'text-red-800': order.status === 'expired'
                        }" x-text="order.status === 'paid' ? @js(__('Pembayaran Berhasil')) : (order.status === 'pending' ? @js(__('Menunggu Pembayaran')) : @js(__('Expired / Gagal')))"></h3>
                        <p class="text-sm text-gray-500" x-text="order.order_number"></p>
                    </div>
                </div>

                <div class="p-6 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">{{ __('Produk') }}</span>
                        <span class="font-medium text-dark-800 text-right" x-text="order.product"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">{{ __('Total') }}</span>
                        <span class="font-bold text-primary-600" x-text="order.amount"></span>
                    </div>
                    <template x-if="order.payment_method">
                        <div class="flex justify-between">
                            <span class="text-gray-500">{{ __('Metode') }}</span>
                            <span class="font-medium text-dark-800" x-text="order.payment_method.toUpperCase()"></span>
                        </div>
                    </template>

                    <template x-if="order.download_url">
                        <div class="pt-4 border-t border-gray-100">
                            <a :href="order.download_url"
                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-all shadow-lg shadow-primary-600/25">
                                <i class="fa-solid fa-download mr-2"></i>
                                {{ __('Download Produk') }}
                            </a>
                            <p class="text-xs text-gray-400 mt-2 text-center" x-text="@js(__('Download tersisa:')) + ' ' + order.download_remaining + 'x'"></p>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function orderLookup() {
        return {
            form: {
                order_number: '',
                email: ''
            },
            loading: false,
            errorMessage: '',
            order: null,

            async lookup() {
                if (!this.form.order_number.trim() || !this.form.email.trim()) {
                    this.errorMessage = @js(__('Nomor order dan email wajib diisi.'));
                    return;
                }

                this.loading = true;
                this.errorMessage = '';
                this.order = null;

                try {
                    const params = new URLSearchParams(this.form);
                    const response = await fetch('{{ route("order.status") }}?' + params.toString(), {
                        headers: {
                            'Accept': 'application/json'
                        },
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        this.errorMessage = data.error || @js(__('Pesanan tidak ditemukan.'));
                    } else {
                        this.order = data;
                    }
                } catch (e) {
                    this.errorMessage = @js(__('Terjadi kesalahan jaringan.'));
                }

                this.loading = false;
            }
        };
    }
</script>
@endpush