<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Reset Password</title>
</head>

<body style="margin:0;padding:0;background-color:#111827;font-family:Arial,Helvetica,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#111827;padding:40px 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="460" cellpadding="0" cellspacing="0" style="background-color:#1f2937;border-radius:16px;border:1px solid #374151;overflow:hidden;">
                    {{-- Header --}}
                    <tr>
                        <td style="padding:32px 32px 0;text-align:center;">
                            <img src="{{ asset('images/logo.png') }}" alt="SuhastraDev" style="width:48px;height:48px;border-radius:12px;display:inline-block;object-fit:contain;">
                            <h1 style="color:#ffffff;font-size:20px;margin:16px 0 4px;">Reset Password</h1>
                            <p style="color:#9ca3af;font-size:14px;margin:0;">SuhastraDev Admin</p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:24px 32px;">
                            <p style="color:#d1d5db;font-size:14px;line-height:1.6;margin:0 0 20px;">
                                Anda menerima email ini karena ada permintaan reset password untuk akun Anda. Gunakan kode OTP berikut:
                            </p>

                            {{-- OTP Code --}}
                            <div style="background-color:#374151;border-radius:12px;padding:20px;text-align:center;margin:0 0 20px;border:1px solid #4b5563;">
                                <span style="color:#ffffff;font-size:36px;font-weight:bold;letter-spacing:8px;">{{ $otp }}</span>
                            </div>

                            <p style="color:#9ca3af;font-size:13px;line-height:1.6;margin:0 0 8px;">
                                Kode ini berlaku selama <strong style="color:#d1d5db;">10 menit</strong>.
                            </p>
                            <p style="color:#9ca3af;font-size:13px;line-height:1.6;margin:0;">
                                Jika Anda tidak meminta reset password, abaikan email ini.
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding:16px 32px 24px;border-top:1px solid #374151;text-align:center;">
                            <p style="color:#6b7280;font-size:12px;margin:0;">&copy; {{ date('Y') }} SuhastraDev. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>