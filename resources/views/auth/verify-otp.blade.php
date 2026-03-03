<x-guest-layout>
    <div class="text-center mb-6">
        <div class="w-12 h-12 bg-indigo-600/20 rounded-xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0119.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 004.5 10.5a48.667 48.667 0 00-1.488 7.556M12 2.25A2.25 2.25 0 0014.25 4.5v.878m-4.5 0V4.5A2.25 2.25 0 0112 2.25m0 0a2.25 2.25 0 012.25 2.25V5.38" />
            </svg>
        </div>
        <h2 class="text-xl font-bold text-white">Verifikasi OTP</h2>
        <p class="text-gray-400 text-sm mt-1">
            Masukkan kode 6 digit yang telah dikirim ke<br>
            <span class="text-indigo-400 font-medium">{{ $email }}</span>
        </p>
    </div>

    @if (session('status'))
    <div class="mb-4 p-3 bg-green-500/10 border border-green-500/30 rounded-lg text-sm text-green-400">
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('password.otp.verify') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <!-- OTP Input -->
        <div>
            <label for="otp" class="block text-sm font-medium text-gray-300 mb-2">Kode OTP</label>
            <div x-data="{
                otp: ['', '', '', '', '', ''],
                focusNext(index) {
                    if (this.otp[index] && index < 5) {
                        this.$refs['otp' + (index + 1)].focus();
                    }
                },
                focusPrev(index, e) {
                    if (e.key === 'Backspace' && !this.otp[index] && index > 0) {
                        this.$refs['otp' + (index - 1)].focus();
                    }
                },
                handlePaste(e) {
                    const text = (e.clipboardData || window.clipboardData).getData('text').trim();
                    if (/^\d{6}$/.test(text)) {
                        text.split('').forEach((d, i) => this.otp[i] = d);
                        this.$refs.otp5.focus();
                    }
                    e.preventDefault();
                },
                get fullOtp() { return this.otp.join(''); }
            }" class="flex gap-2 justify-center" @paste="handlePaste">
                <template x-for="(digit, index) in otp" :key="index">
                    <input
                        :x-ref="'otp' + index"
                        type="text"
                        inputmode="numeric"
                        maxlength="1"
                        x-model="otp[index]"
                        @input="focusNext(index)"
                        @keydown="focusPrev(index, $event)"
                        class="w-12 h-14 text-center text-xl font-bold bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </template>
                <input type="hidden" name="otp" :value="fullOtp">
            </div>
            @error('otp')
            <p class="mt-2 text-sm text-red-400 text-center">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="w-full mt-6 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800">
            Verifikasi
        </button>
    </form>

    <div class="flex items-center justify-between mt-4">
        <a href="{{ route('password.request') }}" class="text-sm text-gray-400 hover:text-indigo-400 transition">
            &larr; Kembali
        </a>
        <form method="POST" action="{{ route('password.otp.resend') }}" class="inline">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button type="submit" class="text-sm text-indigo-400 hover:text-indigo-300 transition">
                Kirim ulang kode
            </button>
        </form>
    </div>
</x-guest-layout>