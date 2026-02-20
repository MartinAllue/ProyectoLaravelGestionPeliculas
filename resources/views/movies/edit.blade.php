@extends('layouts.app')

@section('title', 'Editar película')

@section('content')

    <div class="container" style="max-width: 800px; margin:auto;">

        <h1>Editar película</h1>

        {{-- Mostrar errores --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Verificación de autorización --}}
        @auth
            @if(auth()->id() === $movie->user_id || (auth()->user()->is_admin ?? false))

                <form action="{{ route('movies.update', $movie->id) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- Título --}}
                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text"
                               name="titulo"
                               class="form-control"
                               value="{{ old('titulo', $movie->titulo) }}"
                               required>
                    </div>

                    {{-- Director --}}
                    <div class="mb-3">
                        <label class="form-label">Director</label>
                        <input type="text"
                               name="director"
                               class="form-control"
                               value="{{ old('director', $movie->director) }}">
                    </div>

                    {{-- Año --}}
                    <div class="mb-3">
                        <label class="form-label">Año</label>
                        <input type="number"
                               name="anio"
                               class="form-control"
                               value="{{ old('anio', $movie->anio) }}">
                    </div>

                    {{-- Género --}}
                    <div class="mb-3">
                        <label class="form-label">Género</label>
                        <input type="text"
                               name="genero"
                               class="form-control"
                               value="{{ old('genero', $movie->genero) }}">
                    </div>

                    {{-- País --}}
                    <div class="mb-3">
                        <label class="form-label">País</label>
                        <input type="text"
                               name="pais"
                               class="form-control"
                               value="{{ old('pais', $movie->pais) }}">
                    </div>

                    {{-- Sinopsis --}}
                    <div class="mb-3">
                        <label class="form-label">Sinopsis</label>
                        <textarea name="sinopsis"
                                  class="form-control"
                                  rows="4">{{ old('sinopsis', $movie->sinopsis) }}</textarea>
                    </div>

                    {{-- Imagen actual --}}
                    <div class="mb-3">
                        <label class="form-label">Imagen actual</label><br>

                        @if($movie->imagen_url)
                            <img src="{{ asset('storage/'.$movie->imagen_url) }}"
                                 width="200"
                                 class="mb-2">
                        @else
                            <p>No hay imagen.</p>
                        @endif
                    </div>

                    {{-- Cambiar imagen --}}
                    <div class="mb-3">
                        <label class="form-label">Cambiar imagen (opcional)</label>
                        <input type="file"
                               name="imagen_url"
                               class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Actualizar película
                    </button>

                    <a href="{{ route('movies.show', $movie->id) }}"
                       class="btn btn-secondary">
                        Cancelar
                    </a>

                </form>

            @else
                <div class="alert alert-danger">
                    No tienes permiso para editar esta película.
                </div>
            @endif
        @endauth

    </div>

@endsection
