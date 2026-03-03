<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }

        .header {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            padding: 32px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            font-size: 24px;
            margin: 0;
        }

        .header p {
            color: #c7d2fe;
            font-size: 14px;
            margin: 8px 0 0;
        }

        .body {
            padding: 32px;
        }

        .success-badge {
            display: inline-block;
            background-color: #dcfce7;
            color: #166534;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .info-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #6b7280;
            font-size: 14px;
        }

        .info-value {
            color: #111827;
            font-size: 14px;
            font-weight: 600;
        }

        .download-btn {
            display: inline-block;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #ffffff;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            margin: 20px 0;
        }

        .warning {
            background-color: #fef3c7;
            border: 1px solid #fde68a;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 13px;
            color: #92400e;
            margin-top: 16px;
        }

        .footer {
            background-color: #f9fafb;
            padding: 24px 32px;
            text-align: center;
            color: #9ca3af;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>SuhastraDev</h1>
            <p>Pembayaran Berhasil!</p>
        </div>

        <div class="body">
            <span class="success-badge">✓ Pembayaran Dikonfirmasi</span>

            <p style="color: #374151; font-size: 15px; line-height: 1.6;">
                Halo <strong>{{ $order->buyer_name }}</strong>,<br><br>
                Terima kasih atas pembelian Anda! Pembayaran untuk order <strong>{{ $order->order_number }}</strong> telah berhasil dikonfirmasi.
            </p>

            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Order</span>
                    <span class="info-value">{{ $order->order_number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Produk</span>
                    <span class="info-value">{{ $product->title }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Nominal</span>
                    <span class="info-value">{{ $order->formatted_amount }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Metode</span>
                    <span class="info-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method ?? '-')) }}</span>
                </div>
            </div>

            <div style="text-align: center;">
                <p style="color: #374151; font-size: 15px; font-weight: 600;">Download Source Code Anda:</p>
                <a href="{{ $downloadUrl }}" class="download-btn">⬇ Download Sekarang</a>
            </div>

            <div class="warning">
                <strong>⚠ Penting:</strong> Link download berlaku <strong>3 hari</strong> dan maksimal <strong>2x download</strong>. Simpan file setelah download.
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>Email ini dikirim otomatis, mohon tidak balas email ini.</p>
        </div>
    </div>
</body>

</html>