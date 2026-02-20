@extends('layouts.app')

@section('title', 'Perfil de ' . $user->name)

@section('content')
    <div class="max-w-4xl mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6">Perfil de {{ $user->name }}</h1>

        <div class="bg-gray-800 p-6 rounded-lg mb-8">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Rol:</strong> {{ ucfirst($user->role) }}</p>
            <p><strong>Total películas creadas:</strong> {{ $user->movies->count() }}</p>
        </div>

        <h2 class="text-2xl font-semibold mb-4">Tus Películas</h2>

        @if($movies->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($movies as $movie)
                    <div class="bg-gray-700 p-4 rounded-lg shadow hover:shadow-lg transition">
                        <img src="{{ asset('storage/' . $movie->imagen_url) }}" alt="{{ $movie->titulo }}" class="w-full h-40 object-cover rounded mb-3">
                        <h3 class="text-xl font-semibold mb-2">{{ $movie->titulo }}</h3>
                        <p class="text-gray-300 text-sm">Rating: {{ $movie->valoracion_media ?? 'N/A' }}</p>
                        <a href="{{ route('movies.show', $movie->id) }}" class="mt-2 inline-block text-indigo-500 hover:underline">Ver más</a>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $movies->links() }}
            </div>
        @else
            <p class="text-gray-400">No has creado ninguna película todavía.</p>
        @endif
    </div>
@endsection
