<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreMovieRequest;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::latest();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('director', 'like', "%{$search}%")
                  ->orWhere('genero', 'like', "%{$search}%");
            });
        }

        if ($genero = $request->get('genero')) {
            $query->where('genero', $genero);
        }

        if ($anio = $request->get('anio')) {
            $query->where('anio', $anio);
        }

        $movies = $query->paginate(15)->withQueryString();
        $generos = Movie::select('genero')->distinct()->orderBy('genero')->pluck('genero');
        $anios = Movie::select('anio')->distinct()->orderBy('anio', 'desc')->pluck('anio');

        return view('movies.index', compact('movies', 'generos', 'anios'));
    }

    public function create()
    {
        return view('movies.create');
    }

    public function store(StoreMovieRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if($request->hasFile('imagen_url')){
            $path = $request->file('imagen_url')->store('movies', 'public');
            $data['imagen_url'] = $path;
        } else {
            $data['imagen_url'] = 'movies/default.jpg';
        }

        Movie::create($data);

        return redirect()->route('movies.index')
            ->with('success','Película agregada correctamente.');
    }

    public function show(Movie $movie)
    {
        return view('movies.show',compact('movie'));
    }

    public function edit(Movie $movie)
    {
        return view('movies.edit',compact('movie'));
    }

    public function update(StoreMovieRequest $request, Movie $movie)
    {
        $data = $request->validated();

        if($request->hasFile('imagen_url')){
            if($movie->imagen_url && $movie->imagen_url !== 'movies/default.jpg'){
                Storage::disk('public')->delete($movie->imagen_url);
            }
            $path = $request->file('imagen_url')->store('movies', 'public');
            $data['imagen_url'] = $path;
        }

        $movie->update($data);

        return redirect()->route('movies.show', $movie->id)
            ->with('success','Película actualizada correctamente.');
    }

    public function destroy(Movie $movie)
    {
        if($movie->imagen_url && $movie->imagen_url !== 'movies/default.jpg'){
            Storage::disk('public')->delete($movie->imagen_url);
        }

        $movie->delete();

        return redirect()->route('movies.index')
            ->with('success','Película eliminada correctamente');
    }
}
