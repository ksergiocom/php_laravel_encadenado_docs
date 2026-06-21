@extends('layout.base')

@section('content')
    <div class="p-9 min-h-dvh bg-white">
        <div class="w-fit">
        <h1 class="text-4xl md:text-5xl mb-2">Detalles del evento</h1>
        <p class="text-gray-600 mb-6">Todas las propiedades registradas de este evento.</p>

        <div class="border border-gray-400 p-4 flex flex-col gap-2">
            <p><span class="font-semibold">ID:</span> {{ $evento->id }}</p>
            <p><span class="font-semibold">Tipo:</span> {{ ucfirst($evento->tipo) }}</p>
            <p><span class="font-semibold">Documento:</span>
                {{ $evento->documento ? $evento->documento->titulo . ' (v.' . $evento->documento->version . '.0)' : '—' }}
            </p>
            <p><span class="font-semibold">Documento previo:</span>
                {{ $evento->documentoPrevio ? $evento->documentoPrevio->titulo . ' (v.' . $evento->documentoPrevio->version . '.0)' : '—' }}
            </p>
            <p><span class="font-semibold">Usuario:</span>
                {{ $evento->usuario ? $evento->usuario->nombre . ' ' . $evento->usuario->apellido : '—' }}</p>
            <p><span class="font-semibold">Fecha:</span> {{ $evento->created_at?->format('d/m/Y H:i:s') ?? '—' }}</p>
            <p class="break-all"><span class="font-semibold">Hash del evento:</span> {{ $evento->event_hash }}</p>
            <p class="break-all"><span class="font-semibold">Hash previo:</span> {{ $evento->previous_event_hash ?? '—' }}</p>
            <p class="break-all"><span class="font-semibold">Huella del archivo:</span>
                {{ $evento->documento_file_hash ?? '—' }}</p>
            <p class="break-all"><span class="font-semibold">Huella del archivo previo:</span>
                {{ $evento->documento_previo_file_hash ?? '—' }}</p>
            <p><span class="font-semibold">IP:</span> {{ $evento->ip ?? '—' }}</p>
            <p class="break-all"><span class="font-semibold">User agent:</span> {{ $evento->user_agent ?? '—' }}</p>
            <div>
                <p class="font-semibold mb-1">Payload:</p>
                <pre class="bg-gray-50 border border-gray-200 p-3 text-xs overflow-x-auto">{{ json_encode($evento->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
            </div>
        </div>

        <a href="{{ route('eventos.index') }}" class="border border-gray-400 p-2 px-5 inline-block mt-6">Volver</a>
        </div>
    </div>
@endsection
