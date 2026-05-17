<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold text-danger">Gestión de Películas</h1>
        <p class="lead text-muted">Tu plataforma de cine favorita</p>
        <div class="mt-4">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">Iniciar Sesión</a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Registrarse</a>
        </div>
    </div>
</body>
</html>
