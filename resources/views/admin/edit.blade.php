@extends('layout.base')

@section('content')
    <div class="p-9 min-h-dvh bg-white">
        <div class="max-w-xl">
        <h1 class="text-4xl md:text-5xl mb-2">Sustituir documento</h1>
        <p class="text-gray-600 mb-6">
            Sustituye este documento por una versión nueva. La versión actual quedará
            marcada como «sustituida» y se publicará la nueva.
        </p>

        <form method="post" action="{{ route('admin.update', ['documento' => $documento]) }}" enctype="multipart/form-data"
            class="flex flex-col gap-5">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-1">
                <label for="titulo" class="font-semibold">Título</label>
                <p class="text-sm text-gray-500">El título se conserva del documento original y no puede cambiarse al
                    sustituir.</p>
                <input id="titulo" name="titulo" value="{{ old('titulo', $documento->titulo) }}" readonly type="text"
                    class="border border-gray-400 p-2 w-full bg-gray-100 text-gray-600">
                @error('titulo')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-1">
                <label for="archivo" class="font-semibold">Archivo</label>
                <p class="text-sm text-gray-500">PDF de la nueva versión (solo PDF, máx. 50 MB).</p>
                <input id="archivo" type="file" name="archivo" accept="application/pdf"
                    class="border border-gray-400 p-2 w-full">
                @error('archivo')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex gap-3 items-center">
                <button type="submit" class="bg-black text-white p-2 px-5 inline-block">Sustituir</button>
                <a href="{{ route('admin.index') }}" class="border border-gray-400 p-2 px-5 inline-block">Cancelar</a>
            </div>
        </form>
        </div>
    </div>
@endsection
