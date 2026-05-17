<x-guest-layout>
    <h4 class="text-center text-danger fw-bold mb-4">Iniciar Sesión</h4>

    <x-auth-session-status class="alert alert-info mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" class="form-control mt-1" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="mb-3">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="form-control mt-1" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="form-check mb-3">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label class="form-check-label" for="remember_me">{{ __('Recordarme') }}</label>
        </div>

        <div class="d-flex align-items-center justify-content-between">
            @if (Route::has('password.request'))
                <a class="text-decoration-underline small text-light" href="{{ route('password.request') }}">
                    {{ __('Has olvidado la contraseña?') }}
                </a>
            @endif
            <button type="submit" class="btn btn-danger">Iniciar Sesión</button>
        </div>
    </form>
</x-guest-layout>
