@extends('layout.base')

@section('content')
    <div class="p-9">
        <h1 class="text-4xl md:text-5xl mb-5">Listado de documentos</h1>
        <a class="bg-black text-white p-2 px-5 inline-block mb-7" href="{{ route('admin.create') }}">Publicar documento</a>
        <table class="text-left table-fixed w-full border-collapse">
            <thead>
                <th class="p-2 border border-gray-400 w-1/2">Titulo</th>
                <th class="p-2 border text-center border-gray-400">Versión</th>
                <th class="p-2 border text-center border-gray-400">Estado</th>
                <th class="p-2 border text-center border-gray-400">F.Publicado</th>
                <th class="p-2 border text-center border-gray-400">Acciones</th>
            </thead>
            <tbody>
                @foreach ($documentos as $documento)
                    <tr>
                        <td class="p-2 border border-gray-400 truncate w-1/2">{{ $documento->titulo }}</td>
                        <td class="p-2 text-center border border-gray-400">v. {{ $documento->version }}.0</td>
                        <td class="p-2 text-center border border-gray-400"><span class="capitalize border p-1 px-3 border-green-300 bg-green-100 text-green-700">{{ $documento->estado }}</span></td>
                        <td class="p-2 text-center border border-gray-400">{{ $documento->publicado_at }}</td>
                        <td class="p-2 text-center border border-gray-400">
                            <details class="relative inline-block text-left">
                                <summary class="cursor-pointer list-none select-none text-sm border p-1 px-3 inline-block">Acciones &darr;</summary>
                                <div class="absolute right-0 z-10 mt-1 w-40 flex flex-col text-left bg-white border border-gray-400 shadow-lg">
                                    <a class="p-2 hover:bg-gray-100" href="{{ asset('storage/' . $documento->path) }}">Descargar</a>
                                    @if ($documento->estado == 'publicado')
                                        <a class="p-2 hover:bg-gray-100" href="{{ route('admin.retirar', ['documento' => $documento]) }}">Retirar</a>
                                        <a class="p-2 hover:bg-gray-100" href="{{ route('admin.edit', ['documento' => $documento]) }}">Sustituir</a>
                                    @endif
                                </div>
                            </details>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- <ul>
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
            </ul> -->
    </div>
@endsection