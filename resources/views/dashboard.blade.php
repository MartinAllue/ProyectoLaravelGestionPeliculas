<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold mb-0">{{ __('Dashboard') }}</h2>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <h4>{{ __("¡Has iniciado sesión!") }}</h4>
                    <p class="text-muted">Bienvenido al sistema de Gestión de Películas.</p>
                    <div class="mt-3 d-flex justify-content-center gap-2">
                        <a href="{{ route('movies.index') }}" class="btn btn-primary">Ver Películas</a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-danger">Panel Admin</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
