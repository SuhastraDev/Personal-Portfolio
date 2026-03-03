<?php

namespace App\Http\Controllers;

use App\Mail\OrderPaidMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MidtransWebhookController extends Controller
{
    /**
     * Handle Midtrans payment notification (webhook).
     */
    public function __invoke(Request $request)
    {
        try {
            $orderId = $request->input('order_id');
            $transactionStatus = $request->input('transaction_status');
            $fraudStatus = $request->input('fraud_status');
            $paymentType = $request->input('payment_type');
            $statusCode = $request->input('status_code');
            $grossAmount = $request->input('gross_amount');
            $signatureKey = $request->input('signature_key');

            Log::info("Midtrans Webhook: order={$orderId}, status={$transactionStatus}, fraud={$fraudStatus}, type={$paymentType}");

            // Verifikasi signature key
            $serverKey = config('midtrans.server_key');
            $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

            if ($signatureKey !== $expectedSignature) {
                Log::warning("Midtrans Webhook: Invalid signature for {$orderId}");
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            $order = Order::where('order_number', $orderId)->first();

            if (!$order) {
                Log::warning("Midtrans Webhook: Order not found — {$orderId}");
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Cross-check amount
            if ((int) $order->amount !== (int) $grossAmount) {
                Log::warning("Midtrans Webhook: Amount mismatch for {$orderId}. Expected: {$order->amount}, Got: {$grossAmount}");
                return response()->json(['message' => 'Amount mismatch'], 400);
            }

            // Jangan proses ulang jika sudah paid
            if ($order->status === 'paid') {
                return response()->json(['message' => 'Already paid']);
            }

            if ($transactionStatus === 'capture') {
                // Credit card: cek fraud status
                if ($fraudStatus === 'accept') {
                    $this->handlePaid($order, $paymentType);
                }
            } elseif ($transactionStatus === 'settlement') {
                // Pembayaran berhasil (VA, QRIS, e-wallet, dll)
                $this->handlePaid($order, $paymentType);
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $order->update(['status' => 'expired']);
            } elseif ($transactionStatus === 'pending') {
                $order->update(['status' => 'pending']);
            }

            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            Log::error('Midtrans Webhook Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error'], 500);
        }
    }

    /**
     * Handle successful payment.
     */
    private function handlePaid(Order $order, string $paymentType): void
    {
        $order->update(['payment_method' => $paymentType]);
        $order->generateDownloadToken();

        // Kirim email dengan link download
        try {
            Mail::to($order->buyer_email)->send(new OrderPaidMail($order));
            Log::info("Order paid email sent for {$order->order_number}");
        } catch (\Exception $e) {
            Log::error("Failed to send order email for {$order->order_number}: " . $e->getMessage());
        }
    }
}
