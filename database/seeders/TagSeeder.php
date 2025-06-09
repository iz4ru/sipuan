<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = ['Ramah', 'Cekatan', 'Profesional', 'Jelas', 'Sabar', 'Responsif', 'Lambat', 'Galak', 'Bingung', 'Santai'];

        foreach ($tags as $tag) {
            Tag::create(['tag_name' => $tag]);
        }
    }
}
