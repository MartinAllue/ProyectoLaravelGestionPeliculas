@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
    <h1 class="mb-4">Panel de Administración</h1>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white text-center">
                <div class="card-body">
                    <h3 class="display-6">{{ $totalMovies }}</h3>
                    <p class="mb-0">Películas</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white text-center">
                <div class="card-body">
                    <h3 class="display-6">{{ $totalUsers }}</h3>
                    <p class="mb-0">Usuarios</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white text-center">
                <div class="card-body">
                    <h3 class="display-6">{{ $totalReviews }}</h3>
                    <p class="mb-0">Comentarios</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <a href="{{ route('admin.users') }}" class="text-decoration-none">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-4">
                        <h4>Gestionar Usuarios</h4>
                        <p class="text-muted mb-0">RF-13: Administrar usuarios registrados</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('admin.reviews') }}" class="text-decoration-none">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-4">
                        <h4>Moderar Comentarios</h4>
                        <p class="text-muted mb-0">RF-14: Moderar valoraciones y comentarios</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
