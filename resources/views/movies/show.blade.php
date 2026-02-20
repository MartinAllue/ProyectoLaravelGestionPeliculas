@extends('layouts.app')

@section('title', $movie->titulo)

@section('content')

    <style>
        .movie-container {
            max-width: 900px;
            margin: auto;
        }
        .movie-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .info-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .section {
            margin-top: 40px;
        }
        #rating-system {
            font-size: 2rem;
            color: #ccc;
            cursor: pointer;
            display: inline-block;
        }

        #rating-system .star.selected,
        #rating-system .star.hover {
            color: gold;
        }

        #rating-feedback {
            font-size: 1rem;
            color: #fff;
            margin-left: 10px;
        }
    </style>

    <div class="movie-container">

        {{-- Imagen --}}
        @if($movie->imagen_url)
            <img src="{{ asset('storage/'.$movie->imagen_url) }}"
                 alt="{{ $movie->titulo }}"
                 class="movie-image">
        @else
            <img src="https://placehold.co/900x400"
                 alt="{{ $movie->titulo }}"
                 class="movie-image">
        @endif

        {{-- Información principal --}}
        <div class="info-box">
            <h1>{{ $movie->titulo }}</h1>

            <p><strong>Director:</strong> {{ $movie->director ?? 'No disponible' }}</p>
            <p><strong>Año:</strong> {{ $movie->anio ?? 'No disponible' }}</p>
            <p><strong>Género:</strong> {{ $movie->genero ?? 'No disponible' }}</p>
            <p><strong>País:</strong> {{ $movie->pais ?? 'No disponible' }}</p>

            <p><strong>Valoración media:</strong>
                {{ $movie->valoracion_media ?? 'Sin valoraciones' }}
            </p>

            <p><strong>Sinopsis:</strong></p>
            <p>{{ $movie->sinopsis ?? 'No hay descripción disponible.' }}</p>
        </div>

        {{-- Botones editar y eliminar --}}
        @auth
            @if(auth()->id() === $movie->user_id || auth()->user()->is_admin ?? false)
                <div class="mb-4">
                    <a href="{{ route('movies.edit', $movie->id) }}"
                       class="btn btn-warning">
                        Editar
                    </a>

                    <form action="{{ route('movies.destroy', $movie->id) }}"
                          method="POST"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-danger"
                                onclick="return confirm('¿Seguro que deseas eliminar esta película?')">
                            Eliminar
                        </button>
                    </form>
                </div>
            @endif
        @endauth

        @auth
            <div class="section">
                <h3>Valora esta película</h3>
                <div id="rating-system" data-movie-id="{{ $movie->id }}" data-user-score="{{ optional(Auth::user()->ratings()->where('movie_id', $movie->id)->first())->score ?? 0 }}">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star" data-value="{{ $i }}">&#9733;</span>
                    @endfor
                    <span id="rating-feedback" class="ml-2"></span>
                </div>
                <p>Valoración promedio: <strong id="average-rating">{{ $movie->valoracion_media ?? 'Sin valoraciones' }}</strong></p>
                <p>Total de valoraciones: <strong id="total-ratings">{{ $movie->ratings()->count() }}</strong></p>
            </div>
        @endauth

        {{-- Sección de valoraciones --}}
        <div class="section">
            <h3>Valoraciones</h3>

            @if($movie->ratings && $movie->ratings->count() > 0)
                <ul>
                    @foreach($movie->ratings as $rating)
                        <li>
                            {{ $rating->user->name ?? 'Usuario' }}
                            — ⭐ {{ $rating->score }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No hay valoraciones todavía.</p>
            @endif
        </div>

        {{-- Sección de comentarios --}}
        <div class="section mt-6">
            <h3 class="text-xl font-bold mb-4">Comentarios</h3>

            {{-- Formulario para nuevo comentario (solo usuarios autenticados) --}}
            @auth
                <div class="mb-6 p-4 bg-gray-800 rounded-lg">
                    <form action="{{ route('reviews.store', $movie->id) }}" method="POST">
                        @csrf
                        <input type="text" name="title" placeholder="Título (opcional)"
                               class="w-full mb-2 p-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                        <textarea name="content" rows="4" placeholder="Escribe tu comentario..."
                                  class="w-full p-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>

                        @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            Enviar comentario
                        </button>
                    </form>
                </div>
            @endauth

            {{-- Lista de comentarios --}}
            @if($movie->reviews && $movie->reviews->count() > 0)
                <div class="space-y-4">
                    @foreach($movie->reviews as $review)
                        <div class="p-4 bg-gray-700 rounded-lg text-white">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-semibold">{{ $review->user->name ?? 'Usuario' }}</span>
                                <span class="text-sm text-gray-300">{{ $review->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($review->title)
                                <p class="font-medium">{{ $review->title }}</p>
                            @endif
                            <p>{{ $review->content }}</p>

                            {{-- Botones editar/eliminar solo creador o admin --}}
                            @auth
                                @if(auth()->id() === $review->user_id || auth()->user()->is_admin ?? false)
                                    <div class="mt-2 flex gap-2">
                                        <a href="{{ route('reviews.edit', $review->id) }}"
                                           class="bg-yellow-500 px-2 py-1 rounded text-sm hover:bg-yellow-600">Editar</a>

                                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este comentario?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 px-2 py-1 rounded text-sm hover:bg-red-700">Eliminar</button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 mt-4">Aún no hay comentarios. Sé el primero en opinar!</p>
            @endif
        </div>

    </div>

@endsection

