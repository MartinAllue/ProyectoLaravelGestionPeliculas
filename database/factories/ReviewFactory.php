<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Review;
use App\Models\User;
use App\Models\Movie;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        return [
            'user_id' => 1,
            'movie_id' => 1,
            'title' => 'Review',
            'content' => 'Prueba para factory',
        ];
    }
}
