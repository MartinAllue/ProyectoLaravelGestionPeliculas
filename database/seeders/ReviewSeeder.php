<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        // Generar 40 comentarios aleatorios
        Review::factory()->count(40)->create();
    }
}
