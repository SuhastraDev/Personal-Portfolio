<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        // Buat kategori portfolio
        $categories = [
            ['name' => 'Web Application', 'slug' => 'web-application'],
            ['name' => 'Landing Page', 'slug' => 'landing-page'],
            ['name' => 'Company Profile', 'slug' => 'company-profile'],
            ['name' => 'E-Commerce', 'slug' => 'e-commerce'],
        ];

        foreach ($categories as $cat) {
            PortfolioCategory::create($cat);
        }

        // Buat dummy portfolio
        $portfolios = [
            [
                'title' => 'Sistem Manajemen Inventaris',
                'slug' => 'sistem-manajemen-inventaris',
                'description' => 'Aplikasi web untuk manajemen inventaris dan stok barang dengan fitur barcode scanner, laporan real-time, dan multi-warehouse support. Dibangun untuk PT Logistik Nusantara.',
                'url' => 'https://demo.suhastradev.com/inventaris',
                'client_name' => 'PT Logistik Nusantara',
                'tech_stack' => json_encode(['Laravel 11', 'Vue.js 3', 'MySQL', 'TailwindCSS']),
                'completion_date' => '2025-08-15',
                'is_featured' => true,
                'order' => 1,
                'meta_title' => 'Sistem Manajemen Inventaris - SuhastraDev Portfolio',
                'meta_description' => 'Aplikasi web manajemen inventaris dan stok barang dengan fitur barcode scanner dan laporan real-time.',
            ],
            [
                'title' => 'Website Company Profile Arsitek',
                'slug' => 'company-profile-arsitek',
                'description' => 'Website company profile modern untuk studio arsitektur dengan galeri proyek interaktif, animasi scroll, dan form konsultasi online.',
                'url' => 'https://demo.suhastradev.com/arsitek',
                'client_name' => 'Studio Arsitektur Bali',
                'tech_stack' => json_encode(['Laravel 11', 'TailwindCSS', 'Alpine.js']),
                'completion_date' => '2025-10-20',
                'is_featured' => true,
                'order' => 2,
                'meta_title' => 'Company Profile Studio Arsitektur - SuhastraDev Portfolio',
                'meta_description' => 'Website company profile modern untuk studio arsitektur dengan galeri proyek interaktif.',
            ],
            [
                'title' => 'Toko Online Fashion',
                'slug' => 'toko-online-fashion',
                'description' => 'Platform e-commerce untuk toko fashion online dengan fitur keranjang belanja, pembayaran midtrans, tracking pesanan, dan dashboard admin lengkap.',
                'url' => 'https://demo.suhastradev.com/fashion',
                'client_name' => 'Bali Fashion Store',
                'tech_stack' => json_encode(['Laravel 11', 'Livewire', 'MySQL', 'Midtrans']),
                'completion_date' => '2025-12-01',
                'is_featured' => false,
                'order' => 3,
                'meta_title' => 'Toko Online Fashion - SuhastraDev Portfolio',
                'meta_description' => 'Platform e-commerce fashion online dengan fitur pembayaran midtrans dan tracking pesanan.',
            ],
        ];

        foreach ($portfolios as $data) {
            $portfolio = Portfolio::create($data);

            // Attach random categories
            if ($data['slug'] === 'sistem-manajemen-inventaris') {
                $portfolio->categories()->attach([1]); // Web Application
            } elseif ($data['slug'] === 'company-profile-arsitek') {
                $portfolio->categories()->attach([2, 3]); // Landing Page, Company Profile
            } elseif ($data['slug'] === 'toko-online-fashion') {
                $portfolio->categories()->attach([1, 4]); // Web Application, E-Commerce
            }
        }
    }
}
