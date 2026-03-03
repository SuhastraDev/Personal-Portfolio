<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'Budi Santoso',
                'client_role' => 'CEO, PT Digital Nusantara',
                'content' => 'SuhastraDev sangat profesional dan mengerjakan website kami tepat waktu. Hasilnya sangat memuaskan dan meningkatkan kredibilitas bisnis kami secara online.',
                'rating' => 5,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'client_name' => 'Sari Dewi',
                'client_role' => 'Owner, Toko Online Bali',
                'content' => 'Website e-commerce yang dibuat sangat user-friendly dan responsif. Penjualan kami meningkat 40% setelah menggunakan website baru dari SuhastraDev.',
                'rating' => 5,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'client_name' => 'Ahmad Rizky',
                'client_role' => 'Manager IT, Startup Teknologi',
                'content' => 'Kerja sama yang sangat baik. Komunikasi lancar, revisi ditanggapi cepat, dan source code yang diberikan sangat rapi dan terdokumentasi dengan baik.',
                'rating' => 4,
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
