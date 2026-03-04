<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Hero Section
            ['key' => 'hero_title', 'value' => 'Halo, Saya Indra Jasa Suhastra', 'group' => 'hero'],
            ['key' => 'hero_subtitle', 'value' => 'Full-Stack Web Developer', 'group' => 'hero'],
            ['key' => 'hero_description', 'value' => 'Saya membantu bisnis Anda berkembang melalui website profesional, modern, dan fungsional. Dari company profile hingga aplikasi web custom.', 'group' => 'hero'],
            ['key' => 'hero_cta_text', 'value' => 'Lihat Portfolio', 'group' => 'hero'],
            ['key' => 'hero_cta_url', 'value' => '#portfolio', 'group' => 'hero'],

            // About Section
            ['key' => 'about_name', 'value' => 'Indra Jasa Suhastra', 'group' => 'about'],
            ['key' => 'about_bio', 'value' => 'Seorang Full-Stack Web Developer yang berpengalaman dalam membangun aplikasi web modern menggunakan Laravel, Vue.js, dan teknologi terkini lainnya. Saya berkomitmen untuk memberikan solusi digital terbaik bagi klien.', 'group' => 'about'],
            ['key' => 'about_photo', 'value' => null, 'group' => 'about'],
            ['key' => 'about_experience_years', 'value' => '3', 'group' => 'about'],
            ['key' => 'about_projects_count', 'value' => '25', 'group' => 'about'],
            ['key' => 'about_clients_count', 'value' => '15', 'group' => 'about'],

            // Contact Info
            ['key' => 'contact_email', 'value' => 'hello@suhastradev.com', 'group' => 'contact'],
            ['key' => 'contact_whatsapp', 'value' => '6281234567890', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '081234567890', 'group' => 'contact'],
            ['key' => 'contact_instagram', 'value' => 'https://instagram.com/suhastradev', 'group' => 'contact'],
            ['key' => 'contact_github', 'value' => 'https://github.com/suhastradev', 'group' => 'contact'],
            ['key' => 'contact_linkedin', 'value' => 'https://linkedin.com/in/suhastradev', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'Bali, Indonesia', 'group' => 'contact'],

            // General
            ['key' => 'site_name', 'value' => 'SuhastraDev', 'group' => 'general'],
            ['key' => 'site_logo', 'value' => null, 'group' => 'general'],
            ['key' => 'site_favicon', 'value' => null, 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Website Portfolio & Marketplace Source Code oleh Indra Jasa Suhastra', 'group' => 'general'],
            ['key' => 'footer_text', 'value' => '© 2026 SuhastraDev. All rights reserved.', 'group' => 'general'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']]
            );
        }
    }
}
