@extends('layouts.app')

@section('title', 'Crear Película')

@section('content')
    <div class="min-h-screen bg-gray-100 py-10 px-4">
        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">

            <div class="bg-indigo-600 p-6">
                <h2 class="text-2xl font-bold text-white">Añadir Nueva Película</h2>
                <p class="text-indigo-100">Completa los campos para añadir la película.</p>
            </div>

            {{-- Mostrar errores generales --}}
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('movies.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="p-8 space-y-6">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Título --}}
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Título</label>
                        <input type="text" name="titulo" value="{{ old('titulo') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                        focus:border-indigo-500 focus:ring-indigo-500
                        @error('titulo') border-red-500 @enderror">
                    </div>

                    {{-- Director --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Director</label>
                        <input type="text" name="director" value="{{ old('director') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                        focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    {{-- Año --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Año</label>
                        <input type="number" name="anio" value="{{ old('anio') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                        focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    {{-- Género --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Género</label>
                        <input type="text" name="genero" value="{{ old('genero') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    {{-- País --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">País</label>
                        <input type="text" name="pais" value="{{ old('pais') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                </div>

                {{-- Sinopsis --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sinopsis</label>
                    <textarea name="sinopsis" rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('sinopsis') }}</textarea>
                </div>

                {{-- Rating --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Valoración Media</label>
                    <input type="number" step="0.1" min="0" max="10"
                           name="valoracion_media"
                           value="{{ old('valoracion_media') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                {{-- Imagen --}}
                <div class="bg-gray-50 p-4 rounded-lg border-2 border-dashed border-gray-300">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        URL de la Imagen
                    </label>

                    <input type="text" name="imagen_url"
                           value="{{ old('imagen_url') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm mb-4">

                    <p class="text-xs text-gray-500 mb-2">
                        O subir archivo:
                    </p>

                    <input type="file" name="poster" accept="image/*"
                           class="block w-full text-sm text-gray-500">
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-4 border-t pt-6">
                    <a href="{{ route('movies.index') }}"
                       class="text-gray-500 hover:text-gray-700 font-medium">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2 rounded-md
                    font-semibold hover:bg-indigo-700 transition shadow-md">
                        Guardar Película
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
