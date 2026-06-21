@extends('layout.base')

@section('content')
    <div class="p-9 min-h-dvh bg-white">
        <div class="max-w-xl">
        <h1 class="text-4xl md:text-5xl mb-2">Retirar documento</h1>
        <p class="text-gray-600 mb-6">Vas a retirar este documento. Revisa los datos antes de confirmar.</p>

        <div class="border border-gray-400 p-4 mb-6 flex flex-col gap-1">
            <p><span class="font-semibold">Título:</span> {{ $documento->titulo }}</p>
            <p><span class="font-semibold">Versión:</span> v. {{ $documento->version }}.0</p>
            <p><span class="font-semibold">Estado:</span> {{ $documento->estado }}</p>
        </div>

        @include('admin.partials.aviso-trazabilidad', [
            'detalle' => 'El documento dejará de estar publicado, pero su histórico y sus eventos se conservan.',
        ])

        <form method="POST" action="{{ route('admin.retirar.ejecutar', ['documento' => $documento]) }}"
            class="flex gap-3 items-center mt-6">
            @csrf
            <button type="submit" class="bg-black text-white p-2 px-5 inline-block">Confirmar retiro</button>
            <a href="{{ route('admin.index') }}" class="border border-gray-400 p-2 px-5 inline-block">Cancelar</a>
        </form>
        </div>
    </div>
@endsection
