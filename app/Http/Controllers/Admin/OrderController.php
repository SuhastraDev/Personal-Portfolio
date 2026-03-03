<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('product')->latest();

        if ($request->filled('status')) {
            $query->status($request->status);
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('product');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,cancelled,expired',
        ]);

        if ($validated['status'] === 'paid' && !$order->download_token) {
            $order->generateDownloadToken();
        } elseif ($validated['status'] === 'paid') {
            $order->update(['status' => 'paid', 'paid_at' => now()]);
        } else {
            $order->update([
                'status' => $validated['status'],
            ]);
        }

        return back()->with('success', 'Status order berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dihapus.');
    }
}
