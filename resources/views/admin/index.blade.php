@extends('layout.base')

@section('content')
    <div class="p-9 min-h-dvh bg-white">
        <div class="flex gap-4 mb-7">
            <a class="text-black underline" href="{{ route('admin.index') }}">Documentos</a>
            <a class="text-gray-500 hover:text-black hover:underline" href="{{ route('eventos.index') }}">Eventos</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-black hover:underline cursor-pointer">Cerrar
                    sesión</button>
            </form>
        </div>
        <h1 class="text-4xl md:text-5xl mb-5">Listado de documentos</h1>
        <a class="bg-black text-white p-2 px-5 inline-block mb-7" href="{{ route('admin.publicar') }}">Publicar documento</a>
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
                        <td class="p-2 text-center border border-gray-400"><span class="capitalize border p-1 px-3 rounded {{ $documento->estado == 'publicado' ? 'border-green-300 bg-green-100 text-green-700' : 'border-gray-300 bg-gray-100 text-gray-700' }}">{{ $documento->estado }}</span></td>
                        <td class="p-2 text-center border border-gray-400">{{ $documento->publicado_at }}</td>
                        <td class="p-2 text-center border border-gray-400">
                            <details name="acciones" class="relative inline-block text-left">
                                <summary class="cursor-pointer list-none select-none text-sm border p-1 px-3 inline-block">Acciones &darr;</summary>
                                <div class="acciones-menu absolute right-0 top-full z-20 mt-1 w-44 flex flex-col text-left bg-white border border-gray-400 shadow-lg">
                                    <a class="p-2 hover:bg-gray-100" href="{{ route('admin.show', ['documento' => $documento]) }}">Detalles</a>
                                    <a class="p-2 hover:bg-gray-100" href="{{ asset('storage/' . $documento->path) }}">Mostrar</a>
                                    @if ($documento->estado == 'publicado')
                                        <a class="p-2 hover:bg-gray-100" href="{{ route('admin.retirar', ['documento' => $documento]) }}">Retirar</a>
                                        <a class="p-2 hover:bg-gray-100" href="{{ route('admin.sustituir', ['documento' => $documento]) }}">Sustituir</a>
                                    @endif
                                </div>
                            </details>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection