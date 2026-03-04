<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Baru dari Website</title>
</head>

<body style="margin: 0; padding: 0; background-color: #111827; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <div style="max-width: 600px; margin: 0 auto; padding: 40px 20px;">

        {{-- Logo --}}
        <div style="text-align: center; margin-bottom: 30px;">
            <img src="{{ asset('images/logo.png') }}" alt="SuhastraDev" style="width: 60px; height: 60px; border-radius: 12px;">
        </div>

        {{-- Card --}}
        <div style="background-color: #1f2937; border-radius: 16px; padding: 32px; border: 1px solid #374151;">

            {{-- Header --}}
            <div style="text-align: center; margin-bottom: 24px;">
                <div style="display: inline-block; background-color: #4f46e5; width: 48px; height: 48px; border-radius: 12px; line-height: 48px; margin-bottom: 12px;">
                    <span style="color: #fff; font-size: 20px;">✉</span>
                </div>
                <h1 style="color: #ffffff; font-size: 22px; font-weight: 700; margin: 0 0 4px 0;">Pesan Baru dari Website</h1>
                <p style="color: #9ca3af; font-size: 14px; margin: 0;">Ada seseorang yang mengirim pesan melalui form kontak</p>
            </div>

            <hr style="border: none; border-top: 1px solid #374151; margin: 20px 0;">

            {{-- Pengirim --}}
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 10px 0; color: #9ca3af; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; width: 120px; vertical-align: top;">Nama</td>
                    <td style="padding: 10px 0; color: #f3f4f6; font-size: 15px;">{{ $contact->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; color: #9ca3af; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; vertical-align: top;">Email</td>
                    <td style="padding: 10px 0;">
                        <a href="mailto:{{ $contact->email }}" style="color: #818cf8; font-size: 15px; text-decoration: none;">{{ $contact->email }}</a>
                    </td>
                </tr>
                @if($contact->phone)
                <tr>
                    <td style="padding: 10px 0; color: #9ca3af; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; vertical-align: top;">WhatsApp</td>
                    <td style="padding: 10px 0;">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}" style="color: #34d399; font-size: 15px; text-decoration: none;">{{ $contact->phone }}</a>
                    </td>
                </tr>
                @endif
                @if($contact->service_type)
                <tr>
                    <td style="padding: 10px 0; color: #9ca3af; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; vertical-align: top;">Layanan</td>
                    <td style="padding: 10px 0; color: #f3f4f6; font-size: 15px;">{{ $contact->service_type }}</td>
                </tr>
                @endif
                <tr>
                    <td style="padding: 10px 0; color: #9ca3af; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; vertical-align: top;">Subjek</td>
                    <td style="padding: 10px 0; color: #f3f4f6; font-size: 15px; font-weight: 600;">{{ $contact->subject }}</td>
                </tr>
            </table>

            <hr style="border: none; border-top: 1px solid #374151; margin: 20px 0;">

            {{-- Pesan --}}
            <div style="margin-bottom: 8px;">
                <p style="color: #9ca3af; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 10px 0;">Pesan</p>
                <div style="background-color: #111827; border-radius: 12px; padding: 20px; border: 1px solid #374151;">
                    <p style="color: #e5e7eb; font-size: 15px; line-height: 1.7; margin: 0; white-space: pre-wrap;">{{ $contact->message }}</p>
                </div>
            </div>

            <hr style="border: none; border-top: 1px solid #374151; margin: 20px 0;">

            {{-- Quick Actions --}}
            <div style="text-align: center;">
                <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" style="display: inline-block; background: linear-gradient(135deg, #4f46e5, #6366f1); color: #ffffff; font-size: 14px; font-weight: 600; text-decoration: none; padding: 12px 28px; border-radius: 10px; margin-right: 8px;">
                    Balas Email
                </a>
                @if($contact->phone)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}" style="display: inline-block; background: linear-gradient(135deg, #059669, #10b981); color: #ffffff; font-size: 14px; font-weight: 600; text-decoration: none; padding: 12px 28px; border-radius: 10px;">
                    WhatsApp
                </a>
                @endif
            </div>
        </div>

        {{-- Footer --}}
        <div style="text-align: center; margin-top: 24px;">
            <p style="color: #6b7280; font-size: 12px; margin: 0;">
                Email ini dikirim otomatis dari form kontak <strong style="color: #9ca3af;">SuhastraDev</strong>
            </p>
            <p style="color: #4b5563; font-size: 11px; margin: 8px 0 0 0;">
                {{ now()->format('d M Y, H:i') }} WIB
            </p>
        </div>
    </div>
</body>

</html>