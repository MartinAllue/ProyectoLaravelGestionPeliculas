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
                    <p><strong>Películas creadas:</strong> {{ $user->movies->count() }}</p>
                    <p><strong>Valoraciones realizadas:</strong> {{ $user->ratings->count() }}</p>
                    <p><strong>Reseñas escritas:</strong> {{ $user->reviews->count() }}</p>
                </div>
            </div>

            <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="created-tab" data-bs-toggle="tab" data-bs-target="#created" type="button">Películas creadas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="rated-tab" data-bs-toggle="tab" data-bs-target="#rated" type="button">Valoradas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviewed-tab" data-bs-toggle="tab" data-bs-target="#reviewed" type="button">Reseñadas</button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="created">
                    @if($createdMovies->count() > 0)
                        <div class="row g-4">
                            @foreach($createdMovies as $movie)
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
                        <div class="d-flex justify-content-center mt-4">{{ $createdMovies->links('pagination::bootstrap-5') }}</div>
                    @else
                        <p class="text-muted">No has creado ninguna película.</p>
                    @endif
                </div>

                <div class="tab-pane fade" id="rated">
                    @if($ratedMovies->count() > 0)
                        <div class="row g-4">
                            @foreach($ratedMovies as $rating)
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card h-100 bg-secondary text-white">
                                        <img src="{{ asset('storage/' . $rating->movie->imagen_url) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $rating->movie->titulo }}">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">{{ $rating->movie->titulo }}</h5>
                                            <p class="text-light small">Tu valoración: ⭐ {{ $rating->score }}/5</p>
                                            <div class="mt-auto">
                                                <a href="{{ route('movies.show', $rating->movie->id) }}" class="btn btn-outline-light btn-sm">Ver más</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center mt-4">{{ $ratedMovies->links('pagination::bootstrap-5') }}</div>
                    @else
                        <p class="text-muted">No has valorado ninguna película.</p>
                    @endif
                </div>

                <div class="tab-pane fade" id="reviewed">
                    @if($reviewedMovies->count() > 0)
                        <div class="row g-4">
                            @foreach($reviewedMovies as $review)
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card h-100 bg-secondary text-white">
                                        <img src="{{ asset('storage/' . $review->movie->imagen_url) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $review->movie->titulo }}">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">{{ $review->movie->titulo }}</h5>
                                            <p class="text-light small">"{{ Str::limit($review->content, 80) }}"</p>
                                            <div class="mt-auto">
                                                <a href="{{ route('movies.show', $review->movie->id) }}" class="btn btn-outline-light btn-sm">Ver más</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center mt-4">{{ $reviewedMovies->links('pagination::bootstrap-5') }}</div>
                    @else
                        <p class="text-muted">No has reseñado ninguna película.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
