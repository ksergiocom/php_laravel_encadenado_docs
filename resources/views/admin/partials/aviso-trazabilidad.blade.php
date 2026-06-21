<div class="border border-yellow-500 bg-yellow-50 text-yellow-900 p-4 rounded">
    <p class="font-semibold mb-1">Aviso de trazabilidad</p>
    <p class="text-sm">
        Esta acción quedará registrada y será <strong>visible</strong> para los usuarios.
        El documento <strong>no se elimina</strong>: se conserva en el sistema junto con
        <strong>todos sus eventos</strong> para garantizar la trazabilidad.
    </p>
    @isset($detalle)
        <p class="text-sm mt-2">{{ $detalle }}</p>
    @endisset
</div>
