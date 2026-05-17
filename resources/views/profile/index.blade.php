@extends('layouts.app')

@section('title', 'Perfil de ' . $user->name)

@section('content')
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <h1 class="mb-4">Perfil de {{ $user->name }}</h1>

            <div class="card bg-dark text-white mb-5">
                <div class="card-body">
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Rol:</strong> {{ ucfirst($user->role) }}</p>
                    <p><strong>Total películas creadas:</strong> {{ $user->movies->count() }}</p>
                </div>
            </div>

            <h2 class="mb-4">Tus Películas</h2>

            @if($movies->count() > 0)
                <div class="row g-4">
                    @foreach($movies as $movie)
                        <div class="col-sm-6 col-lg-4">
                            <div class="card h-100 bg-secondary text-white">
                                <img src="{{ asset('storage/' . $movie->imagen_url) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $movie->titulo }}">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $movie->titulo }}</h5>
                                    <p class="text-light small">Rating: {{ $movie->valoracion_media ?? 'N/A' }}</p>
                                    <div class="mt-auto">
                                        <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-outline-light btn-sm">Ver más</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $movies->links('pagination::bootstrap-5') }}
                </div>
            @else
                <p class="text-muted">No has creado ninguna película todavía.</p>
            @endif
        </div>
    </div>
@endsection
