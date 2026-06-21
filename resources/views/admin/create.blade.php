@extends('layout.base')

@section('content')
    <div class="p-9 max-w-xl">
        <h1 class="text-4xl md:text-5xl mb-2">Publicar documento</h1>
        <p class="text-gray-600 mb-6">
            Publica un nuevo documento. El PDF quedará disponible públicamente y se
            registrará su evento de publicación.
        </p>

        <form method="post" action="{{ route('admin.store') }}" enctype="multipart/form-data" class="flex flex-col gap-5">
            @csrf

            <div class="flex flex-col gap-1">
                <label for="titulo" class="font-semibold">Título</label>
                <p class="text-sm text-gray-500">Nombre con el que se mostrará el documento.</p>
                <input id="titulo" name="titulo" value="{{ old('titulo') }}" type="text"
                    class="border border-gray-400 p-2 w-full">
                @error('titulo')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col gap-1">
                <label for="archivo" class="font-semibold">Archivo</label>
                <p class="text-sm text-gray-500">Archivo PDF a publicar (solo PDF, máx. 50 MB).</p>
                <input id="archivo" type="file" name="archivo" accept="application/pdf"
                    class="border border-gray-400 p-2 w-full">
                @error('archivo')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex gap-3 items-center">
                <button type="submit" class="bg-black text-white p-2 px-5 inline-block">Publicar</button>
                <a href="{{ route('admin.index') }}" class="border border-gray-400 p-2 px-5 inline-block">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
