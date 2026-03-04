<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Download produk berdasarkan token.
     */
    public function __invoke(string $token)
    {
        $order = Order::where('download_token', $token)
            ->with('product')
            ->firstOrFail();

        // Validasi download - gunakan atomic update untuk mencegah race condition
        if ($order->status !== 'paid' || $order->download_token === null) {
            abort(403, 'Link download tidak valid.');
        }

        if ($order->download_expires_at !== null && $order->download_expires_at->isPast()) {
            abort(403, 'Link download sudah kedaluwarsa.');
        }

        // Atomic increment: hanya berhasil jika download_count masih < 2
        $updated = Order::where('id', $order->id)
            ->where('download_count', '<', 2)
            ->increment('download_count');

        if (!$updated) {
            abort(403, 'Batas download sudah tercapai.');
        }

        // Pastikan produk & file ada
        $product = $order->product;

        if (! $product || ! $product->file_path) {
            abort(404, 'File produk tidak ditemukan.');
        }

        // Path traversal protection
        if (str_contains($product->file_path, '..') || str_starts_with($product->file_path, '/')) {
            abort(403, 'Path file tidak valid.');
        }

        if (! Storage::exists($product->file_path)) {
            abort(404, 'File produk tidak ditemukan di server.');
        }

        // Increment product download count
        $product->increment('download_count');

        // Generate filename untuk download
        $extension = pathinfo($product->file_path, PATHINFO_EXTENSION);
        $filename = str($product->title)->slug() . '.' . $extension;

        return Storage::download($product->file_path, $filename);
    }
}
