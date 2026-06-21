@extends('layout.base')

@section('content')
    <div class="p-9 max-w-xl">
        <h1 class="text-4xl md:text-5xl mb-2">Sustituir documento</h1>
        <p class="text-gray-600 mb-6">Vas a sustituir este documento por una versión nueva. Revisa los datos antes de
            continuar.</p>

        <div class="border border-gray-400 p-4 mb-6 flex flex-col gap-1">
            <p><span class="font-semibold">Título:</span> {{ $documento->titulo }}</p>
            <p><span class="font-semibold">Versión:</span> v. {{ $documento->version }}.0</p>
            <p><span class="font-semibold">Estado:</span> {{ $documento->estado }}</p>
        </div>

        @include('admin.partials.aviso-trazabilidad', [
            'detalle' => 'La versión actual quedará marcada como «sustituida» y se publicará la nueva. El documento original y sus eventos se conservan.',
        ])

        <div class="flex gap-3 items-center mt-6">
            <a href="{{ route('admin.edit', ['documento' => $documento]) }}"
                class="bg-black text-white p-2 px-5 inline-block">Continuar</a>
            <a href="{{ route('admin.index') }}" class="border border-gray-400 p-2 px-5 inline-block">Cancelar</a>
        </div>
    </div>
@endsection
