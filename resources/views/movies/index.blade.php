@extends("layouts.app")

@section('title', 'Peliculas')

@section('content')
    <style>
        .intro {
            text-align: center;
            margin-bottom: 40px;
        }
        .intro h1 {
            color: #333;
            margin-bottom: 15px;
        }
        .movies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }
        .movie-card {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 25px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .movie-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .movie-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .movie-card h2 {
            color: #667eea;
            margin-bottom: 10px;
        }
        .movie-info {
            background: white;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
            font-size: 0.9rem;
            color: #666;
        }
        .card-actions {
            margin-top: 15px;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
    </style>
    <div class="intro">
        <h1>Descubre nuevas peliculas </h1>
        <p>Explora tus peliculas favoritas y las opiniones de nuestros usuarios</p>

        @auth
            <a href="{{ route('movies.create') }}" class="btn btn-primary">
                Crear nuevo
            </a>
        @endauth
    </div>

    @if($movies->count()>0)
        <div class="movies-grid">
            @foreach($movies as $movie)
                <div class="movie-card">
                    @if($movie->imagen_url)
                        <img src="{{ asset('storage/'.$movie->imagen_url) }}" alt="{{ $movie->titulo }}">
                    @else
                        <img src="https://placehold.co/300x180" alt="{{$movie->titulo}}">
                    @endif

                    <h2>{{$movie->titulo}}</h2>

                    <div class="movie-info">
                        Rating: {{$movie->valoracion_media ?? 'N/A'}}
                    </div>

                    <div class="card-actions"> {{-- Boton ver mas --}}
                        <a href="{{route('movies.show', $movie->id)}}" class="btn btn-primary">
                            Ver mas...
                        </a>
                    </div>

                </div>

            @endforeach
        </div>

        <div style="margin-top:40px; text-align:center;">
            {{ $movies->links() }}
        </div>

    @else

    <div class="empty-state">
        <h2>No hay peliculas registradas</h2>
        <p>Aun no hay contenido disponible</p>

        @auth
            <a href="{{route('movies.create')}}" class="btn btn-primary">
                Crear nuevo
            </a>
        @endauth
    </div>
    @endif

@endsection


