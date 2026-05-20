@extends('layouts.app')

@section('title', 'Moderar Comentarios')

@section('content')
    <h1 class="mb-4">Moderar Comentarios</h1>

    <div class="card shadow">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Película</th>
                        <th>Título</th>
                        <th>Contenido</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                        <tr>
                            <td>{{ $review->id }}</td>
                            <td>{{ $review->user->name ?? 'Eliminado' }}</td>
                            <td>
                                <a href="{{ route('movies.show', $review->movie_id) }}">{{ $review->movie->titulo ?? 'Eliminada' }}</a>
                            </td>
                            <td>{{ $review->title ?? '—' }}</td>
                            <td>{{ Str::limit($review->content, 60) }}</td>
                            <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este comentario permanentemente?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $reviews->links('pagination::bootstrap-5') }}
    </div>
@endsection
