<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Portfolio;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'portfolios' => Portfolio::count(),
            'products' => Product::active()->count(),
            'orders' => Order::count(),
            'unreadMessages' => Contact::unread()->count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'revenue' => Order::where('status', 'paid')->sum('amount'),
        ];

        // Saldo dihitung dari total order paid (Midtrans tidak menyediakan API cek saldo)
        $balance = [
            'total'     => Order::where('status', 'paid')->sum('amount'),
            'thisMonth' => Order::where('status', 'paid')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount'),
            'paidCount' => Order::where('status', 'paid')->count(),
        ];

        $recentMessages = Contact::latest()->take(5)->get();
        $recentOrders = Order::with('product')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'balance', 'recentMessages', 'recentOrders'));
    }
}
