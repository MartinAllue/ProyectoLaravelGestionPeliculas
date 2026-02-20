<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMovieRequest;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::latest()->paginate(15);;

        return view('movies.index', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('movies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request)
    {

        $data = $request->validated();

        $data['user_id'] = auth()->id();

        if($request->hasFile('imagen_url')){
            $path = $request->file('imagen_url')->store('movies', 'public');
            $data['imagen_url'] = $path;
        } else {
            // Imagen por defecto
            $data['imagen_url'] = 'movies/default.jpg';
        }

        Movie::create($data);

        return redirect()->route('movies.index')
            ->with('success','Pelicula agregada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        return view('movies.show',compact('movie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        return view('movies.edit',compact('movie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMovieRequest $request, Movie $movie)
    {
        if(auth()->id() !== $movie->user_id && !(auth()->user()->is_admin ?? false)){
            abort(403);
        }

        $data = $request->validated();

        if($request->hasFile('imagen_url')){

            // Eliminar imagen antigua si no es la default
            if($movie->imagen_url && $movie->imagen_url !== 'movies/default.jpg'){
                Storage::disk('public')->delete($movie->imagen_url);
            }

            // Guardar nueva imagen
            $path = $request->file('imagen_url')->store('movies', 'public');
            $data['imagen_url'] = $path;
        }

        $movie->update($data);

        return redirect()->route('movies.show', $movie->id)
            ->with('success','Película actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        if($movie->imagen_url && $movie->imagen_url !== 'movies/default.jpg'){
            Storage::disk('public')->delete($movie->imagen_url);
        }

        $movie->delete();

        return redirect()->route('movies.index')
            ->with('success','Pelicula eliminada correctamente');
    }
}
