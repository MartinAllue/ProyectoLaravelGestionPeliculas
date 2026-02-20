<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'movie_id',
        'score',
    ];

    // Validación en el modelo
    public static $rules = [
        'score' => 'required|integer|min:1|max:5',
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con película
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
