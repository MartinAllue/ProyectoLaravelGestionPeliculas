@extends("layouts.app")

@section('title', 'Películas')

@section('content')
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold">Descubre nuevas películas</h1>
        <p class="text-muted">Explora tus películas favoritas y las opiniones de nuestros usuarios</p>
        @auth
            <a href="{{ route('movies.create') }}" class="btn btn-primary btn-lg">Crear nueva película</a>
        @endauth
    </div>

    @if($movies->count() > 0)
        <div class="row g-4">
            @foreach($movies as $movie)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        @if($movie->imagen_url)
                            <img src="{{ asset('storage/'.$movie->imagen_url) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $movie->titulo }}">
                        @else
                            <img src="https://placehold.co/300x200?text={{ urlencode($movie->titulo) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $movie->titulo }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $movie->titulo }}</h5>
                            <p class="card-text text-muted small mb-1">
                                <span class="badge bg-warning text-dark">Rating: {{ number_format($movie->valoracion_media, 1) ?? 'N/A' }}</span>
                            </p>
                            <div class="mt-auto">
                                <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-outline-primary w-100">Ver más...</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $movies->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="text-center py-5">
            <h3 class="text-muted">No hay películas registradas</h3>
            <p>Aún no hay contenido disponible</p>
            @auth
                <a href="{{ route('movies.create') }}" class="btn btn-primary">Crear nueva película</a>
            @endauth
        </div>
    @endif
@endsection
