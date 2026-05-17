<x-guest-layout>
    <div class="alert alert-info text-sm">
        {{ __('¿Olvidaste tu contraseña? Indícanos tu correo y te enviaremos un enlace para restablecerla.') }}
    </div>

    <x-auth-session-status class="alert alert-success mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control mt-1" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-danger">{{ __('Enviar enlace') }}</button>
        </div>
    </form>
</x-guest-layout>
