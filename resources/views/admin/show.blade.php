@extends('layout.base')

@section('content')
    <div class="p-9 min-h-dvh bg-white">
        <div class="w-fit">
        <h1 class="text-4xl md:text-5xl mb-2">Detalles del documento</h1>
        <p class="text-gray-600 mb-6">Todas las propiedades registradas de este documento.</p>

        <div class="border border-gray-400 p-4 flex flex-col gap-2">
            <p><span class="font-semibold">ID:</span> {{ $documento->id }}</p>
            <p><span class="font-semibold">Título:</span> {{ $documento->titulo }}</p>
            <p><span class="font-semibold">Slug:</span> {{ $documento->slug }}</p>
            <p><span class="font-semibold">Versión:</span> v. {{ $documento->version }}.0</p>
            <p><span class="font-semibold">Estado:</span> {{ ucfirst($documento->estado) }}</p>
            <p><span class="font-semibold">Archivo:</span> {{ $documento->file_name }}</p>
            <p class="break-all"><span class="font-semibold">Huella SHA-256:</span> {{ $documento->file_hash }}</p>
            <p><span class="font-semibold">Integridad del archivo:</span>
                {{ $documento->hashValido() ? 'Válida' : 'No válida' }}</p>
            <p><span class="font-semibold">Publicado el:</span>
                {{ $documento->publicado_at?->format('d/m/Y H:i') ?? '—' }}</p>
            <p><span class="font-semibold">Publicado por:</span>
                {{ $documento->publicadoPorUsuario ? $documento->publicadoPorUsuario->nombre . ' ' . $documento->publicadoPorUsuario->apellido : '—' }}
            </p>
            <p><span class="font-semibold">Retirado el:</span>
                {{ $documento->retirado_at?->format('d/m/Y H:i') ?? '—' }}</p>
            <p><span class="font-semibold">Retirado por:</span>
                {{ $documento->retiradoPorUsuario ? $documento->retiradoPorUsuario->nombre . ' ' . $documento->retiradoPorUsuario->apellido : '—' }}
            </p>
            <p><span class="font-semibold">Sustituye a:</span>
                {{ $documento->sustituyeADocumento ? $documento->sustituyeADocumento->titulo . ' (v.' . $documento->sustituyeADocumento->version . '.0)' : '—' }}
            </p>
            <p><span class="font-semibold">Sustituido por:</span>
                {{ $documento->sustituidoPorDocumento ? $documento->sustituidoPorDocumento->titulo . ' (v.' . $documento->sustituidoPorDocumento->version . '.0)' : '—' }}
            </p>
            <p><span class="font-semibold">Creado:</span> {{ $documento->created_at?->format('d/m/Y H:i') ?? '—' }}</p>
            <p><span class="font-semibold">Actualizado:</span> {{ $documento->updated_at?->format('d/m/Y H:i') ?? '—' }}</p>
        </div>

        <a href="{{ route('admin.index') }}" class="border border-gray-400 p-2 px-5 inline-block mt-6">Volver</a>
        </div>
    </div>
@endsection
