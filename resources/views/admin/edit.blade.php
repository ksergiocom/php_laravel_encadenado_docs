@extends('layout.base')

@section('content')
    <h1>Editar documento</h1>
    <form method="post" action="{{ route('admin.update', ['documento' => $documento]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input name="titulo" value="{{ old('titulo', $documento->titulo) }}" readonly type="text">
        @error('titulo')
            <span>{{ $message }}</span>
        @enderror
        <input type="file" name="archivo" id="archivo" value="{{ old('archivo') }}" accept="application/pdf">
        @error('archivo')
            <span>{{ $message }}</span>
        @enderror
        <input type="submit" value="Actualizar">
    </form>
@endsection
