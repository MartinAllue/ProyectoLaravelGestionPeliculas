<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    protected $fillable =[
        'titulo',
        'director',
        'anio',
        'duracion',
        'imagen_url',
        'genero',
        'sinopsis',
        'reparto',
        'pais',
        'clasificacion_edad',
        'valoracion',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function ratings(){
        return $this->hasMany(Rating::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class)->latest();
    }

    public function updateAverageRating()
    {
        $average = $this->ratings()->avg('score'); // Promedio Eloquent
        $this->valoracion_media = $average ? round($average, 2) : null;
        $this->save();
    }

}
