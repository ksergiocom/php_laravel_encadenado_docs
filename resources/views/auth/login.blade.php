@extends('layout.base')

@section('content')
    <div class="h-dvh w-full bg-white flex flex-col items-center sm:justify-center">
        <div class="w-full sm:max-w-md flex flex-col gap-3 p-10">
            <h1 class="text-4xl mb-3">Iniciar sesión</h1>
            <form class="flex flex-col gap-3" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="flex flex-col gap-1">
                    <label class="text-sm" for="email">Email</label>
                    <input class="border border-gray-400 p-2" placeholder="ejemplo@correo.com" type="email" name="email"
                        id="email" value="{{ old('email') }}" required autofocus>
                </div>
                @error('email')
                    <p class="font-light">{{ $message }}</p>
                @enderror
                <div class="flex flex-col gap-1">
                    <label class="text-sm" for="password">Contraseña</label>
                    <input class="border border-gray-400 p-2" placeholder="******" type="password" name="password"
                        id="password" required>
                </div>
                @error('password')
                    <p>{{ $message }}</p>
                @enderror
                <div>
                    <label class="text-sm">
                        <input type="checkbox" name="remember">
                        Recordarme
                    </label>
                </div>
                <button class="bg-black text-white cursor-pointer px-4 p-2 mt-5" type="submit">Entrar</button>
            </form>
        </div>
    </div>
@endsection