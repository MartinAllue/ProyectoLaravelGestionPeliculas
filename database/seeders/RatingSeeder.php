<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Movie;
use App\Models\Rating;

class RatingSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $movies = Movie::all();

        foreach ($movies as $movie) {
            foreach ($users as $user) {
                // 50% de probabilidad de que el usuario valore la película
                if(rand(0,1)) {
                    Rating::create([
                        'user_id' => $user->id,
                        'movie_id' => $movie->id,
                        'score' => rand(1,5),
                    ]);
                }
            }
        }
    }
}
