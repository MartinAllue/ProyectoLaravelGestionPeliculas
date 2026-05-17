<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-dark">
    <div class="min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <div class="text-center mb-4">
            <a href="{{ route('movies.index') }}" class="text-danger fw-bold text-decoration-none" style="font-size: 2rem;">
                Gestión de Películas
            </a>
        </div>
        <div class="card bg-secondary text-white" style="width: 100%; max-width: 450px;">
            <div class="card-body p-4">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
