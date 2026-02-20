<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Movie;
use App\Models\User;

class MovieFactory extends Factory
{
    protected $model = Movie::class;

    protected $titles = [
        'The Shawshank Redemption',
        'The Godfather',
        'The Dark Knight',
        'Pulp Fiction',
        'Forrest Gump',
        'Inception',
        'Fight Club',
        'The Matrix',
        'Gladiator',
        'Interstellar',
        'The Lord of the Rings: The Fellowship of the Ring',
        'The Lion King',
        'Titanic',
        'Jurassic Park',
        'Star Wars: Episode IV – A New Hope',
        'Avengers: Endgame',
        'The Silence of the Lambs',
        'Saving Private Ryan',
        'Back to the Future',
        'Toy Story'
    ];

    protected $genres = [
        'Acción', 'Comedia', 'Drama', 'Terror', 'Ciencia ficción', 'Aventura', 'Animación', 'Romance'
    ];

    protected $directors = [
        'Steven Spielberg', 'Christopher Nolan', 'Quentin Tarantino',
        'James Cameron', 'Martin Scorsese', 'Peter Jackson',
        'Ridley Scott', 'Francis Ford Coppola', 'Robert Zemeckis', 'David Fincher'
    ];

    protected $countries = [
        'USA', 'UK', 'Canada', 'Australia', 'France', 'Germany', 'Japan'
    ];

    public function definition()
    {
        return [
            'titulo' => $this->faker->unique()->randomElement($this->titles),
            'director' => $this->faker->randomElement($this->directors),
            'anio' => $this->faker->numberBetween(1970, 2023),
            'genero' => $this->faker->randomElement($this->genres),
            'pais' => $this->faker->randomElement($this->countries),
            'sinopsis' => $this->faker->paragraph(3),
            'valoracion_media' => $this->faker->randomFloat(1, 1, 9.9),
            'imagen_url' => 'movies/default.jpg',
            'user_id' => User::inRandomOrder()->first()->id ?? 1,
        ];
    }
}

