@extends('layout.base')

@section('content')
    <div class="p-9 min-h-dvh bg-white">
        <div class="flex gap-4 mb-7">
            <a class="text-gray-500 hover:text-black hover:underline" href="{{ route('admin.index') }}">Documentos</a>
            <a class="text-black underline" href="{{ route('eventos.index') }}">Eventos</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-black hover:underline cursor-pointer">Cerrar
                    sesión</button>
            </form>
        </div>

        <h1 class="text-4xl md:text-5xl mb-12">Listado de eventos</h1>

        <table class="text-left table-fixed w-full border-collapse">
            <thead>
                <th class="p-2 border text-center border-gray-400 w-16">ID</th>
                <th class="p-2 border border-gray-400">Tipo</th>
                <th class="p-2 border border-gray-400 w-1/3">Documento</th>
                <th class="p-2 border border-gray-400">Usuario</th>
                <th class="p-2 border text-center border-gray-400">Fecha</th>
                <th class="p-2 border text-center border-gray-400">Acciones</th>
            </thead>
            <tbody>
                @foreach ($eventos as $evento)
                    <tr>
                        <td class="p-2 text-center border border-gray-400">{{ $evento->id }}</td>
                        <td class="p-2 border border-gray-400"><span
                                class="capitalize border p-1 px-3 rounded {{ $evento->tipo == 'publicado' ? 'border-green-300 bg-green-100 text-green-700' : 'border-gray-300 bg-gray-100 text-gray-700' }}">{{ $evento->tipo }}</span>
                        </td>
                        <td class="p-2 border border-gray-400 truncate">{{ $evento->documento?->titulo ?? '—' }}</td>
                        <td class="p-2 border border-gray-400 truncate">{{ $evento->usuario ? $evento->usuario->nombre . ' ' . $evento->usuario->apellido : '—' }}</td>
                        <td class="p-2 text-center border border-gray-400">{{ $evento->created_at?->format('d/m/Y H:i') }}</td>
                        <td class="p-2 text-center border border-gray-400">
                            <a class="border p-1 px-3 inline-block hover:bg-gray-100"
                                href="{{ route('eventos.show', ['evento' => $evento]) }}">Detalles</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
