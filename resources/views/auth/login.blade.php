@extends('layout.base')

@section('content')
    <h1>Iniciar sesión</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
        </div>

        @error('email')
            <p>{{ $message }}</p>
        @enderror

        <div>
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div>
            <label>
                <input type="checkbox" name="remember">
                Recordarme
            </label>
        </div>

        <button type="submit">Entrar</button>
    </form>
@endsection
