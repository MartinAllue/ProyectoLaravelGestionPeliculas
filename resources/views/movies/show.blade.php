@extends('layouts.app')

@section('title', $movie->titulo)

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            @if($movie->imagen_url)
                <img src="{{ asset('storage/'.$movie->imagen_url) }}" class="img-fluid rounded mb-4" style="max-height: 400px; width: 100%; object-fit: cover;" alt="{{ $movie->titulo }}">
            @else
                <img src="https://placehold.co/900x400?text={{ urlencode($movie->titulo) }}" class="img-fluid rounded mb-4" style="width: 100%;" alt="{{ $movie->titulo }}">
            @endif

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h1 class="card-title mb-4">{{ $movie->titulo }}</h1>

                    <div class="row mb-3">
                        <div class="col-sm-6 mb-2"><strong>Director:</strong> {{ $movie->director ?? 'No disponible' }}</div>
                        <div class="col-sm-6 mb-2"><strong>Año:</strong> {{ $movie->anio ?? 'No disponible' }}</div>
                        <div class="col-sm-6 mb-2"><strong>Género:</strong> {{ $movie->genero ?? 'No disponible' }}</div>
                        <div class="col-sm-6 mb-2"><strong>País:</strong> {{ $movie->pais ?? 'No disponible' }}</div>
                        <div class="col-sm-6 mb-2"><strong>Valoración media:</strong>
                            <span class="badge bg-warning text-dark fs-6">{{ $movie->valoracion_media ?? 'Sin valoraciones' }}</span>
                        </div>
                    </div>

                    <h5>Sinopsis</h5>
                    <p class="text-muted">{{ $movie->sinopsis ?? 'No hay descripción disponible.' }}</p>
                </div>
            </div>

            @auth
                @if(auth()->user()->isAdmin())
                    <div class="mb-4">
                        <a href="{{ route('movies.edit', $movie->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta película?')">Eliminar</button>
                        </form>
                    </div>
                @endif

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5>Valora esta película</h5>
                        <div id="rating-system" class="mb-2" data-movie-id="{{ $movie->id }}" data-user-score="{{ optional(Auth::user()->ratings()->where('movie_id', $movie->id)->first())->score ?? 0 }}">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star" data-value="{{ $i }}" style="font-size: 2rem; cursor: pointer; color: #ccc;">&#9733;</span>
                            @endfor
                            <span id="rating-feedback" class="ms-2 fw-bold"></span>
                        </div>
                        <p class="mb-0">Valoración promedio: <strong id="average-rating">{{ $movie->valoracion_media ?? 'Sin valoraciones' }}</strong></p>
                        <p>Total de valoraciones: <strong id="total-ratings">{{ $movie->ratings()->count() }}</strong></p>
                    </div>
                </div>
            @endauth

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5>Valoraciones</h5>
                    @if($movie->ratings && $movie->ratings->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($movie->ratings as $rating)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $rating->user->name ?? 'Usuario' }}
                                    <span class="badge bg-warning text-dark rounded-pill">⭐ {{ $rating->score }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mb-0">No hay valoraciones todavía.</p>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Comentarios</h5>

                    @auth
                        <div class="bg-light p-3 rounded mb-4">
                            <form action="{{ route('reviews.store', $movie->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" name="title" placeholder="Título (opcional)" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <textarea name="content" rows="4" placeholder="Escribe tu comentario..." class="form-control @error('content') is-invalid @enderror"></textarea>
                                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Enviar comentario</button>
                            </form>
                        </div>
                    @endauth

                    @if($movie->reviews && $movie->reviews->count() > 0)
                        @foreach($movie->reviews as $review)
                            <div class="card mb-3 bg-dark text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong>{{ $review->user->name ?? 'Usuario' }}</strong>
                                        <small class="text-light">{{ $review->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    @if($review->title)
                                        <h6 class="fw-bold">{{ $review->title }}</h6>
                                    @endif
                                    <p class="mb-2">{{ $review->content }}</p>
                                    @auth
                                        @if(auth()->id() === $review->user_id || auth()->user()->isAdmin())
                                            <div class="d-flex gap-2">
                                                @if(auth()->id() === $review->user_id)
                                                    <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                                @endif
                                                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este comentario?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">Aún no hay comentarios. ¡Sé el primero en opinar!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ratingSystem = document.getElementById('rating-system');
        if (!ratingSystem) return;

        const stars = ratingSystem.querySelectorAll('.star');
        const feedback = document.getElementById('rating-feedback');
        const avgRating = document.getElementById('average-rating');
        const totalRatings = document.getElementById('total-ratings');
        const movieId = ratingSystem.dataset.movieId;
        const userScore = parseInt(ratingSystem.dataset.userScore) || 0;

        function highlightStars(value) {
            stars.forEach(s => {
                s.style.color = parseInt(s.dataset.value) <= value ? 'gold' : '#ccc';
            });
        }

        function setStars(value) {
            highlightStars(value);
            if (feedback) feedback.textContent = value > 0 ? `Has votado ${value}/5` : '';
        }

        if (userScore > 0) setStars(userScore);

        stars.forEach(star => {
            star.addEventListener('mouseenter', function() {
                highlightStars(parseInt(this.dataset.value));
            });
            star.addEventListener('mouseleave', function() {
                setStars(parseInt(ratingSystem.dataset.userScore) || 0);
            });
            star.addEventListener('click', function() {
                const value = parseInt(this.dataset.value);
                fetch(`/movies/${movieId}/rating`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ score: value })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        ratingSystem.dataset.userScore = data.user_score;
                        setStars(data.user_score);
                        if (avgRating) avgRating.textContent = data.average ?? 'Sin valoraciones';
                        if (totalRatings) totalRatings.textContent = data.total;
                        if (feedback) feedback.textContent = data.message;
                    }
                })
                .catch(() => {
                    if (feedback) feedback.textContent = 'Error al guardar valoración';
                });
            });
        });
    });
</script>
@endpush
