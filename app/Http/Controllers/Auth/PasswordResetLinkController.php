<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetOtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Generate OTP and send it to the user's email.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Check if the user exists
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Delete any existing OTPs for this email
        PasswordResetOtp::where('email', $request->email)->delete();

        // Generate 6-digit OTP
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store OTP (valid for 10 minutes)
        PasswordResetOtp::create([
            'email'      => $request->email,
            'otp'        => bcrypt($otp),
            'expires_at' => now()->addMinutes(10),
        ]);

        // Send OTP via email
        Mail::to($request->email)->send(new PasswordResetOtpMail($otp));

        // Redirect to OTP verify page
        return redirect()->route('password.otp.show', ['email' => $request->email])
            ->with('status', 'Kode OTP telah dikirim ke email Anda.');
    }
}
