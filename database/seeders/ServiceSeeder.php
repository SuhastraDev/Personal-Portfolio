<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Company Profile',
                'description' => 'Website company profile profesional untuk menampilkan profil bisnis, layanan, portfolio, dan kontak perusahaan Anda. Desain modern dan responsif.',
                'icon' => 'building-office',
                'price_start' => 1500000,
                'price_end' => 3000000,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Landing Page',
                'description' => 'Landing page yang dirancang untuk mengkonversi pengunjung menjadi pelanggan. Dilengkapi dengan CTA yang efektif, form kontak, dan desain yang menarik.',
                'icon' => 'rocket-launch',
                'price_start' => 800000,
                'price_end' => 2000000,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'E-Commerce / Toko Online',
                'description' => 'Platform toko online lengkap dengan manajemen produk, keranjang belanja, checkout, integrasi payment gateway, dan dashboard admin untuk mengelola pesanan.',
                'icon' => 'shopping-cart',
                'price_start' => 3000000,
                'price_end' => 8000000,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'title' => 'Maintenance & Support',
                'description' => 'Layanan pemeliharaan website bulanan: update security, backup rutin, monitoring uptime, perbaikan bug, dan penambahan fitur minor sesuai kebutuhan.',
                'icon' => 'wrench-screwdriver',
                'price_start' => 500000,
                'price_end' => null,
                'is_active' => true,
                'order' => 4,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
