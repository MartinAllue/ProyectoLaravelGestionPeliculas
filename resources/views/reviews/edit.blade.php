@extends('layouts.app')

@section('title', 'Editar comentario')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">Editar Comentario</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('reviews.update', $review->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Título</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $review->title) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contenido <span class="text-danger">*</span></label>
                            <textarea name="content" rows="5" class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $review->content) }}</textarea>
                            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('movies.show', $review->movie_id) }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
