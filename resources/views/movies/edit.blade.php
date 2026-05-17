@extends('layouts.app')

@section('title', 'Editar película')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Editar Película</h4>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger mb-0 rounded-0">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @auth
                    @if(auth()->id() === $movie->user_id || (auth()->user()->is_admin ?? false))
                        <div class="card-body">
                            <form action="{{ route('movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Título <span class="text-danger">*</span></label>
                                        <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $movie->titulo) }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Director</label>
                                        <input type="text" name="director" class="form-control" value="{{ old('director', $movie->director) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Año</label>
                                        <input type="number" name="anio" class="form-control" value="{{ old('anio', $movie->anio) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Género</label>
                                        <input type="text" name="genero" class="form-control" value="{{ old('genero', $movie->genero) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">País</label>
                                        <input type="text" name="pais" class="form-control" value="{{ old('pais', $movie->pais) }}">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Sinopsis</label>
                                        <textarea name="sinopsis" class="form-control" rows="4">{{ old('sinopsis', $movie->sinopsis) }}</textarea>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Imagen actual</label><br>
                                        @if($movie->imagen_url)
                                            <img src="{{ asset('storage/'.$movie->imagen_url) }}" class="img-thumbnail mb-2" style="max-width: 200px;">
                                        @else
                                            <p class="text-muted">No hay imagen.</p>
                                        @endif
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Cambiar imagen (opcional)</label>
                                        <input type="file" name="imagen_url" class="form-control">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                                    <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Actualizar Película</button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-danger m-3">No tienes permiso para editar esta película.</div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
@endsection
