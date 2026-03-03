<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Buat kategori produk
        $categories = [
            ['name' => 'Template Website', 'slug' => 'template-website'],
            ['name' => 'Landing Page', 'slug' => 'landing-page'],
            ['name' => 'Dashboard Admin', 'slug' => 'dashboard-admin'],
            ['name' => 'Aplikasi Lengkap', 'slug' => 'aplikasi-lengkap'],
        ];

        foreach ($categories as $cat) {
            ProductCategory::create($cat);
        }

        // Buat tag produk
        $tags = [
            ['name' => 'Laravel', 'slug' => 'laravel'],
            ['name' => 'Vue.js', 'slug' => 'vuejs'],
            ['name' => 'React', 'slug' => 'react'],
            ['name' => 'TailwindCSS', 'slug' => 'tailwindcss'],
            ['name' => 'Livewire', 'slug' => 'livewire'],
            ['name' => 'MySQL', 'slug' => 'mysql'],
            ['name' => 'REST API', 'slug' => 'rest-api'],
            ['name' => 'Bootstrap', 'slug' => 'bootstrap'],
        ];

        foreach ($tags as $tag) {
            ProductTag::create($tag);
        }

        // Buat dummy produk
        $products = [
            [
                'title' => 'Laravel Admin Dashboard Starter',
                'slug' => 'laravel-admin-dashboard-starter',
                'description' => 'Starter kit admin dashboard lengkap dengan Laravel 12 + TailwindCSS. Sudah termasuk manajemen user, role & permission, CRUD generator, dan chart analytics. Cocok untuk memulai project admin panel dengan cepat.',
                'features' => json_encode(['Multi Auth (Admin & User)', 'Role & Permission (Spatie)', 'CRUD Generator', 'Chart Analytics', 'Dark Mode', 'Responsive Design', 'Export PDF & Excel']),
                'tech_stack' => json_encode(['Laravel 12', 'TailwindCSS', 'Alpine.js', 'MySQL']),
                'price' => 150000,
                'demo_url' => 'https://demo.suhastradev.com/admin-starter',
                'version' => 'v1.0',
                'category_id' => 3, // Dashboard Admin
                'is_active' => true,
                'meta_title' => 'Laravel Admin Dashboard Starter - SuhastraDev',
                'meta_description' => 'Starter kit admin dashboard lengkap dengan Laravel 12 + TailwindCSS. Multi auth, role permission, dan CRUD generator.',
            ],
            [
                'title' => 'Landing Page Builder Template',
                'slug' => 'landing-page-builder-template',
                'description' => 'Template landing page modern dan responsif dengan berbagai section yang bisa dikustomisasi. Dilengkapi dengan form kontak, testimonial slider, pricing table, dan animasi scroll yang smooth.',
                'features' => json_encode(['12+ Section Siap Pakai', 'Fully Responsive', 'SEO Optimized', 'Form Kontak dengan Validasi', 'Testimonial Slider', 'Pricing Table', 'Smooth Scroll Animation']),
                'tech_stack' => json_encode(['HTML5', 'TailwindCSS', 'Alpine.js', 'AOS.js']),
                'price' => 75000,
                'demo_url' => 'https://demo.suhastradev.com/landing-template',
                'version' => 'v2.1',
                'category_id' => 2, // Landing Page
                'is_active' => true,
                'meta_title' => 'Landing Page Builder Template - SuhastraDev',
                'meta_description' => 'Template landing page modern dan responsif dengan 12+ section siap pakai. SEO optimized.',
            ],
            [
                'title' => 'Sistem Kasir / POS Laravel',
                'slug' => 'sistem-kasir-pos-laravel',
                'description' => 'Aplikasi Point of Sale (POS) lengkap untuk toko retail. Fitur: manajemen produk & kategori, transaksi kasir, laporan penjualan harian/bulanan, manajemen stok, cetak struk, dan multi-user access.',
                'features' => json_encode(['Manajemen Produk & Kategori', 'Transaksi Kasir Real-time', 'Laporan Penjualan (Harian/Bulanan)', 'Manajemen Stok Otomatis', 'Cetak Struk Thermal', 'Multi User Access', 'Dashboard Analytics', 'Barcode Scanner Support']),
                'tech_stack' => json_encode(['Laravel 12', 'Livewire 3', 'MySQL', 'TailwindCSS']),
                'price' => 350000,
                'demo_url' => 'https://demo.suhastradev.com/pos',
                'version' => 'v1.2',
                'category_id' => 4, // Aplikasi Lengkap
                'is_active' => true,
                'meta_title' => 'Sistem Kasir POS Laravel - SuhastraDev',
                'meta_description' => 'Aplikasi Point of Sale (POS) lengkap untuk toko retail dengan Laravel 12 dan Livewire.',
            ],
        ];

        foreach ($products as $data) {
            $product = Product::create($data);

            // Attach tags
            if ($data['slug'] === 'laravel-admin-dashboard-starter') {
                $product->tags()->attach([1, 4, 6]); // Laravel, TailwindCSS, MySQL
            } elseif ($data['slug'] === 'landing-page-builder-template') {
                $product->tags()->attach([4]); // TailwindCSS
            } elseif ($data['slug'] === 'sistem-kasir-pos-laravel') {
                $product->tags()->attach([1, 5, 6, 4]); // Laravel, Livewire, MySQL, TailwindCSS
            }
        }
    }
}
