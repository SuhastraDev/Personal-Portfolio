<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetOtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Show the OTP verification form.
     */
    public function showOtpForm(Request $request): View
    {
        return view('auth.verify-otp', [
            'email' => $request->query('email', old('email', '')),
        ]);
    }

    /**
     * Verify the OTP code.
     */
    public function verifyOtp(Request $request): RedirectResponse|View
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp'   => ['required', 'string', 'size:6'],
        ]);

        $record = PasswordResetOtp::where('email', $request->email)
            ->latest()
            ->first();

        if (! $record) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
        }

        if ($record->expires_at->isPast()) {
            $record->delete();
            return back()->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa. Silakan minta kode baru.']);
        }

        if (! Hash::check($request->otp, $record->otp)) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
        }

        // OTP valid — delete it and show reset password form
        $record->delete();

        // Store verification in session
        session(['otp_verified_email' => $request->email]);

        return view('auth.reset-password', [
            'email' => $request->email,
        ]);
    }

    /**
     * Resend OTP.
     */
    public function resendOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Delete existing OTPs
        PasswordResetOtp::where('email', $request->email)->delete();

        // Generate new OTP
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        PasswordResetOtp::create([
            'email'      => $request->email,
            'otp'        => bcrypt($otp),
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($request->email)->send(new PasswordResetOtpMail($otp));

        return back()->with('status', 'Kode OTP baru telah dikirim ke email Anda.');
    }

    /**
     * Handle an incoming new password request (after OTP verified).
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Verify that OTP was previously validated via session
        if (session('otp_verified_email') !== $request->email) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Sesi verifikasi OTP tidak valid. Silakan ulangi proses.']);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $user->forceFill([
            'password'       => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));

        // Clear session
        session()->forget('otp_verified_email');

        return redirect()->route('login')->with('status', 'Password berhasil direset. Silakan login.');
    }
}
