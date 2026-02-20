<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Guardar un nuevo comentario
     */
    public function store(StoreReviewRequest $request, Movie $movie)
    {
        // Verifico si ya existe review del usuario para esta película
        $review = Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'movie_id' => $movie->id,
            ],
            $request->validated() // solo title y content
        );

        return redirect()->route('movies.show', $movie->id)
            ->with('success', 'Tu comentario ha sido guardado.');
    }

    /**
     * Editar un comentario
     */
    public function update(Request $request, Review $review)
    {
        // Solo el creador o admin puede editar
        if ($review->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'No tienes permisos para editar este comentario.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $review->update($request->only(['title', 'content']));

        return redirect()->route('movies.show', $review->movie_id)
            ->with('success', 'Comentario actualizado.');
    }

    /**
     * Eliminar un comentario
     */
    public function destroy(Review $review)
    {
        // Solo el creador o admin puede eliminar
        if ($review->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'No tienes permisos para eliminar este comentario.');
        }

        $movieId = $review->movie_id;
        $review->delete();

        return redirect()->route('movies.show', $movieId)
            ->with('success', 'Comentario eliminado.');
    }
}
