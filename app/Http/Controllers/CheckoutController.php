<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $serverKey = config('midtrans.server_key');
        $clientKey = config('midtrans.client_key');

        if (empty($serverKey) || empty($clientKey)) {
            Log::error('Midtrans: Server key or client key is not configured.');
        }

        MidtransConfig::$serverKey = $serverKey;
        MidtransConfig::$clientKey = $clientKey;
        MidtransConfig::$isProduction = config('midtrans.is_production');
        MidtransConfig::$isSanitized = config('midtrans.is_sanitized');
        MidtransConfig::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Tampilkan form checkout.
     */
    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        return view('pages.checkout', compact('product'));
    }

    /**
     * Proses checkout — buat order + Snap token.
     */
    public function process(Request $request, Product $product)
    {
        // Rate limit: max 5 checkout per IP per minute
        $key = 'checkout:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json([
                'error' => 'Terlalu banyak percobaan. Silakan tunggu beberapa saat.',
            ], 429);
        }
        RateLimiter::hit($key, 60);

        $validated = $request->validate([
            'buyer_name' => 'required|string|max:255',
            'buyer_email' => 'required|email|max:255',
            'buyer_phone' => 'required|string|max:20',
        ]);

        if (!$product->is_active) {
            abort(404);
        }

        // Buat order
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'buyer_name' => $validated['buyer_name'],
            'buyer_email' => $validated['buyer_email'],
            'buyer_phone' => $validated['buyer_phone'],
            'product_id' => $product->id,
            'amount' => $product->price,
            'status' => 'pending',
            'payment_method' => 'midtrans',
        ]);

        // Buat Midtrans Snap transaction
        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->amount,
            ],
            'customer_details' => [
                'first_name' => $order->buyer_name,
                'email' => $order->buyer_email,
                'phone' => $order->buyer_phone,
            ],
            'item_details' => [
                [
                    'id' => $product->id,
                    'price' => (int) $product->price,
                    'quantity' => 1,
                    'name' => str()->limit($product->title, 50),
                ],
            ],
            'callbacks' => [
                'finish' => route('checkout.finish', $order->order_number),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            $order->update(['payment_ref' => $snapToken]);

            Log::info("Checkout success: Order {$order->order_number}, Product: {$product->title}, Amount: {$order->amount}");

            return response()->json([
                'snap_token' => $snapToken,
                'order_number' => $order->order_number,
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Error: ' . $e->getMessage(), [
                'order_number' => $order->order_number ?? null,
                'product_id' => $product->id,
                'amount' => $product->price,
                'server_key_set' => !empty(config('midtrans.server_key')),
                'is_production' => config('midtrans.is_production'),
            ]);

            $order->delete();

            return response()->json([
                'error' => 'Gagal memproses pembayaran. Silakan coba lagi nanti.',
            ], 500);
        }
    }

    /**
     * Halaman setelah pembayaran (redirect dari Midtrans).
     */
    public function finish(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('product')
            ->firstOrFail();

        return view('pages.checkout-finish', compact('order'));
    }

    /**
     * Cek status order (public, tanpa login).
     */
    public function status(Request $request)
    {
        // AJAX request — return JSON
        if ($request->wantsJson() && $request->filled('order_number') && $request->filled('email')) {
            $order = Order::where('order_number', $request->order_number)
                ->where('buyer_email', $request->email)
                ->with('product')
                ->first();

            if (!$order) {
                return response()->json(['error' => 'Pesanan tidak ditemukan. Pastikan nomor order dan email benar.'], 404);
            }

            $data = [
                'order_number' => $order->order_number,
                'product' => $order->product->title ?? '-',
                'amount' => $order->formatted_amount,
                'status' => $order->status,
                'payment_method' => $order->payment_method,
                'download_url' => $order->isDownloadable() ? route('download', $order->download_token) : null,
                'download_remaining' => $order->isDownloadable() ? (2 - $order->download_count) : 0,
            ];

            return response()->json($data);
        }

        // Normal page load
        return view('pages.order-status');
    }
}
