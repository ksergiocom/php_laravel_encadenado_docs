<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hola</title>
</head>
<body>
    <h1>Hola mundo!</h1>

    @if($documentos->isNotEmpty())
        <ul>
            @foreach($documentos as $documento)
                <li>
                    <a href="{{ asset('storage/' . $documento->path) }}">{{ $documento->titulo }} 
                        @if($documento->estado != 'publicado') 
                            ({{ $documento->estado }})
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p>No hay documentos disponibles.</p>
    @endif

    @auth
        <p>Bienvenido, {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}</p>
        <a href="{{ route('admin.index') }}">Admin</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit">Salir</button>
        </form>
    @else
        <a href="{{ route('login') }}">Entrar</a>
    @endauth
</body>
</html>
