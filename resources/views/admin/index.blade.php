<h1>Admin documentos</h1>
<a href="{{ route('admin.create') }}">Subir nuevo</a>
<ul>
    @foreach ($documentos as $documento)
        <li>
            {{ $documento }}
            @if($documento->estado == 'publicado')
                <a href="{{ route('admin.retirar', ['documento' => $documento]) }}">Retirar</a>
                <a href="{{ route('admin.edit', ['documento' => $documento]) }}">Editar</a>
            @endif
            <a href="{{ route('admin.show', ['documento' => $documento]) }}">Detalles</a>
            <a href="{{ asset('storage/' . $documento->path) }}">Descargar PDF</a>
        </li>
    @endforeach
</ul>