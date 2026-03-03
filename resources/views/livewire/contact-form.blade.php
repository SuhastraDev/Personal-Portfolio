<div>
    @if ($submitted)
    {{-- Success State --}}
    <div class="text-center py-12">
        <div class="w-20 h-20 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-5 animate-scale-up">
            <svg class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h3 class="font-heading text-2xl font-bold text-dark-900 mb-3">{{ __('Pesan Terkirim!') }}</h3>
        <p class="text-dark-500 mb-6 max-w-sm mx-auto">{{ __('Terima kasih sudah menghubungi. Saya akan membalas pesan Anda secepatnya.') }}</p>
        <button wire:click="resetForm" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-indigo-600 text-white font-semibold rounded-2xl hover:from-primary-500 hover:to-indigo-500 transition-all duration-300 shadow-lg shadow-primary-600/25 hover:shadow-xl">
            {{ __('Kirim Pesan Lagi') }}
        </button>
    </div>
    @else
    {{-- Contact Form --}}
    <form wire:submit.prevent="submit" class="space-y-5">
        {{-- Honeypot (hidden) --}}
        <div class="hidden" aria-hidden="true">
            <input type="text" wire:model="honeypot" tabindex="-1" autocomplete="off">
        </div>

        {{-- Rate Limit Error --}}
        @if ($rateLimitError)
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
            <div class="flex items-center gap-2 text-amber-700 text-sm font-medium">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ $rateLimitError }}
            </div>
        </div>
        @endif

        {{-- Global Error Banner --}}
        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex items-center gap-2 text-red-700 text-sm font-medium">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                {{ __('Mohon perbaiki kesalahan berikut sebelum mengirim pesan.') }}
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="name" class="block text-sm font-medium text-dark-700 mb-1.5">{{ __('Nama Lengkap') }} <span class="text-red-500">*</span></label>
                <input type="text" id="name" wire:model="name"
                    class="w-full rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm @error('name') border-red-300 @enderror"
                    placeholder="{{ __('Nama Anda') }}">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-dark-700 mb-1.5">{{ __('Email') }} <span class="text-red-500">*</span></label>
                <input type="email" id="email" wire:model="email"
                    class="w-full rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm @error('email') border-red-300 @enderror"
                    placeholder="contoh@email.com">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="phone" class="block text-sm font-medium text-dark-700 mb-1.5">{{ __('No. WhatsApp') }}</label>
                <input type="text" id="phone" wire:model="phone"
                    class="w-full rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm @error('phone') border-red-300 @enderror"
                    placeholder="08xxxxxxxxxx">
                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="service_type" class="block text-sm font-medium text-dark-700 mb-1.5">{{ __('Jenis Kebutuhan') }}</label>
                <select id="service_type" wire:model="service_type"
                    class="w-full rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                    <option value="">{{ __('Pilih layanan...') }}</option>
                    @foreach ($services as $service)
                    <option value="{{ $service->title }}">{{ $service->translated_title }}</option>
                    @endforeach
                    <option value="Lainnya">{{ __('Lainnya') }}</option>
                </select>
                @error('service_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="subject" class="block text-sm font-medium text-dark-700 mb-1.5">{{ __('Subjek') }} <span class="text-red-500">*</span></label>
            <input type="text" id="subject" wire:model="subject"
                class="w-full rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm @error('subject') border-red-300 @enderror"
                placeholder="{{ __('Subjek pesan Anda') }}">
            @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="message" class="block text-sm font-medium text-dark-700 mb-1.5">{{ __('Pesan') }} <span class="text-red-500">*</span></label>
            <textarea id="message" wire:model="message" rows="5"
                class="w-full rounded-xl border-gray-200 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm @error('message') border-red-300 @enderror"
                placeholder="{{ __('Ceritakan kebutuhan Anda...') }}"></textarea>
            @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
            class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-500 hover:to-indigo-500 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg shadow-primary-600/25 hover:shadow-xl hover:shadow-primary-600/40"
            wire:loading.attr="disabled"
            wire:loading.class="opacity-75 cursor-wait">
            <span wire:loading.remove wire:target="submit">
                <svg class="w-5 h-5 mr-2 inline" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                </svg>
                {{ __('Kirim Pesan') }}
            </span>
            <span wire:loading wire:target="submit">
                <svg class="w-5 h-5 mr-2 inline animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ __('Mengirim...') }}
            </span>
        </button>
    </form>
    @endif
</div>