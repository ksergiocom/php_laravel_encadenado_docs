@extends('layout.base')

@section('content')
    <div class="p-9 min-h-dvh bg-white">
        <div class="max-w-xl">
        <h1 class="text-4xl md:text-5xl mb-2">Publicar documento</h1>
        <p class="text-gray-600 mb-6">Vas a publicar un documento nuevo. Revisa el aviso antes de continuar.</p>

        @include('admin.partials.aviso-trazabilidad', [
            'detalle' => 'El documento quedará disponible públicamente y se registrará su evento de publicación. A partir de ahí su histórico y sus eventos se conservan.',
        ])

        <div class="flex gap-3 items-center mt-6">
            <a href="{{ route('admin.create') }}" class="bg-black text-white p-2 px-5 inline-block">Continuar</a>
            <a href="{{ route('admin.index') }}" class="border border-gray-400 p-2 px-5 inline-block">Cancelar</a>
        </div>
        </div>
    </div>
@endsection
