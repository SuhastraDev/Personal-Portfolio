@extends('layouts.app')

@section('title', __('Checkout'))
@section('meta_title', __('Checkout') . ' — ' . $product->translated_title)

@section('content')
{{-- Header --}}
<section class="bg-gradient-to-br from-dark-950 via-dark-900 to-primary-950 pt-32 pb-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 bg-grid-pattern bg-grid"></div>
    </div>
    <div class="absolute top-1/4 right-10 w-64 h-64 bg-primary-500/10 rounded-full blur-[80px]"></div>
    <div class="absolute top-20 right-20 w-20 h-20 border border-white/10 rounded-2xl rotate-12 animate-float hidden sm:block"></div>
    <div class="absolute bottom-10 left-16 w-14 h-14 border border-primary-400/20 rounded-full animate-float-slow hidden sm:block"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur-md text-primary-300 text-xs font-semibold rounded-full uppercase tracking-wider mb-5 border border-white/10 shadow-sm" data-aos="fade-up">
                <i class="fa-solid fa-cart-shopping"></i> Checkout
            </span>
            <h1 class="font-heading text-4xl sm:text-5xl font-bold text-white mb-4" data-aos="fade-up" data-aos-delay="100">{{ __('Checkout') }}</h1>
            <p class="text-dark-300 max-w-xl mx-auto text-lg" data-aos="fade-up" data-aos-delay="150">{{ __('Lengkapi data di bawah untuk melanjutkan pembayaran.') }}</p>
        </div>
    </div>
</section>

{{-- Checkout Form --}}
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8" x-data="checkoutForm()">

            {{-- Form --}}
            <div class="lg:col-span-3" data-aos="fade-right">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:p-8">
                    <h2 class="font-heading text-xl font-bold text-dark-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 bg-primary-50 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-user-pen text-xs text-primary-600"></i>
                        </span>
                        {{ __('Data Pembeli') }}
                    </h2>

                    <div class="space-y-5">
                        <div>
                            <label for="buyer_name" class="block text-sm font-medium text-dark-700 mb-1.5">{{ __('Nama Lengkap') }} <span class="text-red-500">*</span></label>
                            <input type="text" id="buyer_name" x-model="form.buyer_name" required
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 text-sm py-3"
                                placeholder="{{ __('Masukkan nama lengkap') }}"
                                :class="errors.buyer_name && 'border-red-400 focus:ring-red-500 focus:border-red-500'">
                            <p x-show="errors.buyer_name" x-text="errors.buyer_name" class="text-red-500 text-xs mt-1"></p>
                        </div>

                        <div>
                            <label for="buyer_email" class="block text-sm font-medium text-dark-700 mb-1.5">{{ __('Email') }} <span class="text-red-500">*</span></label>
                            <input type="email" id="buyer_email" x-model="form.buyer_email" required
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 text-sm py-3"
                                placeholder="contoh@email.com"
                                :class="errors.buyer_email && 'border-red-400 focus:ring-red-500 focus:border-red-500'">
                            <p x-show="errors.buyer_email" x-text="errors.buyer_email" class="text-red-500 text-xs mt-1"></p>
                            <p class="text-xs text-gray-400 mt-1">{{ __('Link download akan dikirim ke email ini.') }}</p>
                        </div>

                        <div>
                            <label for="buyer_phone" class="block text-sm font-medium text-dark-700 mb-1.5">{{ __('No. WhatsApp') }} <span class="text-red-500">*</span></label>
                            <input type="tel" id="buyer_phone" x-model="form.buyer_phone" required
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 text-sm py-3"
                                placeholder="08xxxxxxxxxx"
                                :class="errors.buyer_phone && 'border-red-400 focus:ring-red-500 focus:border-red-500'">
                            <p x-show="errors.buyer_phone" x-text="errors.buyer_phone" class="text-red-500 text-xs mt-1"></p>
                        </div>
                    </div>

                    {{-- Pay Button --}}
                    <button @click="submitCheckout()" :disabled="loading"
                        class="w-full mt-8 inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-500 hover:to-indigo-500 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg shadow-primary-600/25 hover:shadow-xl hover:shadow-primary-600/40 disabled:opacity-50 disabled:cursor-not-allowed">
                        <template x-if="!loading">
                            <span class="flex items-center">
                                <i class="fa-solid fa-lock mr-2 text-sm"></i>
                                {{ __('Bayar Sekarang') }} — {{ $product->formatted_price }}
                            </span>
                        </template>
                        <template x-if="loading">
                            <span class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                {{ __('Memproses...') }}
                            </span>
                        </template>
                    </button>

                    {{-- Error message --}}
                    <div x-show="errorMessage" x-text="errorMessage"
                        class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700 text-center"></div>

                    {{-- Security notes --}}
                    <div class="mt-6 flex items-start gap-3 p-4 bg-green-50/50 rounded-xl border border-green-100/50">
                        <i class="fa-solid fa-shield-halved text-green-500 mt-0.5"></i>
                        <div>
                            <p class="text-xs font-medium text-dark-700">{{ __('Pembayaran Aman') }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ __('Transaksi diproses melalui Midtrans dengan enkripsi SSL. Data Anda aman dan terlindungi.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-2" data-aos="fade-left">
                <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl border border-gray-100 shadow-sm p-6 sticky top-24">
                    <h3 class="font-heading text-lg font-bold text-dark-900 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 bg-primary-50 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-receipt text-xs text-primary-600"></i>
                        </span>
                        {{ __('Ringkasan') }}
                    </h3>

                    {{-- Product --}}
                    <div class="flex gap-4 pb-4 border-b border-gray-100">
                        @if ($product->thumbnail)
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->translated_title }}"
                            class="w-20 h-14 rounded-lg object-cover shrink-0">
                        @else
                        <div class="w-20 h-14 bg-gradient-to-br from-primary-100 to-primary-50 rounded-lg flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-code text-primary-400"></i>
                        </div>
                        @endif
                        <div class="min-w-0">
                            <h4 class="text-sm font-semibold text-dark-900 truncate">{{ $product->translated_title }}</h4>
                            @if ($product->category)
                            <p class="text-xs text-gray-500">{{ $product->category->translated_name }}</p>
                            @endif
                            @if ($product->version)
                            <p class="text-xs text-gray-400">v{{ $product->version }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Price breakdown --}}
                    <div class="py-4 space-y-2 border-b border-gray-100">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">{{ __('Harga') }}</span>
                            <span class="text-dark-700">{{ $product->formatted_price }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Qty</span>
                            <span class="text-dark-700">1</span>
                        </div>
                    </div>

                    {{-- Total --}}
                    <div class="pt-4 flex justify-between items-center">
                        <span class="font-semibold text-dark-900">{{ __('Total') }}</span>
                        <span class="text-xl font-bold text-primary-600">{{ $product->formatted_price }}</span>
                    </div>

                    {{-- Payment methods --}}
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <p class="text-xs font-semibold text-gray-500 mb-3">{{ __('Metode Pembayaran:') }}</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-50 rounded-lg text-xs text-gray-600 border border-gray-100">
                                <i class="fa-solid fa-qrcode text-gray-400"></i> QRIS
                            </span>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-50 rounded-lg text-xs text-gray-600 border border-gray-100">
                                <i class="fa-solid fa-building-columns text-gray-400"></i> Virtual Account
                            </span>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-50 rounded-lg text-xs text-gray-600 border border-gray-100">
                                <i class="fa-solid fa-wallet text-gray-400"></i> E-Wallet
                            </span>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-50 rounded-lg text-xs text-gray-600 border border-gray-100">
                                <i class="fa-solid fa-credit-card text-gray-400"></i> Credit Card
                            </span>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-50 rounded-lg text-xs text-gray-600 border border-gray-100">
                                <i class="fa-solid fa-store text-gray-400"></i> Minimarket
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<!-- Midtrans Snap.js -->
<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    function checkoutForm() {
        return {
            form: {
                buyer_name: '',
                buyer_email: '',
                buyer_phone: '',
            },
            errors: {},
            loading: false,
            errorMessage: '',

            validate() {
                this.errors = {};
                if (!this.form.buyer_name.trim()) this.errors.buyer_name = @js(__('Nama wajib diisi.'));
                if (!this.form.buyer_email.trim()) this.errors.buyer_email = @js(__('Email wajib diisi.'));
                else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.buyer_email)) this.errors.buyer_email = @js(__('Format email tidak valid.'));
                if (!this.form.buyer_phone.trim()) this.errors.buyer_phone = @js(__('No. WhatsApp wajib diisi.'));
                return Object.keys(this.errors).length === 0;
            },

            async submitCheckout() {
                if (!this.validate()) return;

                // Check if Midtrans Snap.js is loaded
                if (typeof window.snap === 'undefined' || !window.snap) {
                    this.errorMessage = @js(__('Sistem pembayaran sedang dimuat. Tunggu beberapa detik lalu coba lagi.'));
                    return;
                }

                this.loading = true;
                this.errorMessage = '';

                try {
                    const response = await fetch('{{ route("checkout.process", $product->slug) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(this.form),
                    });

                    let data;
                    try {
                        data = await response.json();
                    } catch (parseError) {
                        this.errorMessage = @js(__('Respon server tidak valid. Silakan coba lagi.'));
                        this.loading = false;
                        return;
                    }

                    if (!response.ok) {
                        if (response.status === 429) {
                            this.errorMessage = @js(__('Terlalu banyak percobaan. Tunggu beberapa saat.'));
                        } else if (data.errors) {
                            this.errors = {};
                            for (const [key, messages] of Object.entries(data.errors)) {
                                this.errors[key] = messages[0];
                            }
                        } else {
                            this.errorMessage = data.error || @js(__('Terjadi kesalahan. Silakan coba lagi.'));
                        }
                        this.loading = false;
                        return;
                    }

                    if (!data.snap_token) {
                        this.errorMessage = @js(__('Token pembayaran tidak diterima. Silakan coba lagi.'));
                        this.loading = false;
                        return;
                    }

                    // Open Midtrans Snap popup
                    window.snap.pay(data.snap_token, {
                        onSuccess: (result) => {
                            window.location.href = '{{ route("checkout.finish", ":order") }}'.replace(':order', data.order_number);
                        },
                        onPending: (result) => {
                            window.location.href = '{{ route("checkout.finish", ":order") }}'.replace(':order', data.order_number);
                        },
                        onError: (result) => {
                            this.errorMessage = @js(__('Pembayaran gagal. Silakan coba lagi.'));
                            this.loading = false;
                        },
                        onClose: () => {
                            this.loading = false;
                        }
                    });
                } catch (e) {
                    console.error('Checkout error:', e);
                    this.errorMessage = @js(__('Terjadi kesalahan jaringan. Silakan coba lagi.'));
                    this.loading = false;
                }
            }
        };
    }
</script>
@endpush