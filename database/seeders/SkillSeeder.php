<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            ['name' => 'PHP', 'icon' => 'devicon-php-plain', 'level' => 90, 'order' => 1],
            ['name' => 'Laravel', 'icon' => 'devicon-laravel-original', 'level' => 90, 'order' => 2],
            ['name' => 'JavaScript', 'icon' => 'devicon-javascript-plain', 'level' => 80, 'order' => 3],
            ['name' => 'TailwindCSS', 'icon' => 'devicon-tailwindcss-original', 'level' => 85, 'order' => 4],
            ['name' => 'MySQL', 'icon' => 'devicon-mysql-original', 'level' => 85, 'order' => 5],
            ['name' => 'Vue.js', 'icon' => 'devicon-vuejs-plain', 'level' => 70, 'order' => 6],
            ['name' => 'Git', 'icon' => 'devicon-git-plain', 'level' => 80, 'order' => 7],
            ['name' => 'HTML/CSS', 'icon' => 'devicon-html5-plain', 'level' => 95, 'order' => 8],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
