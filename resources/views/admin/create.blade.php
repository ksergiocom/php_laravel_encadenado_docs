@extends('layout.base')

@section('content')
    <h1>Subir documento</h1>
    <form method="post" action="{{ route('admin.store') }}" enctype="multipart/form-data">
        @csrf
        <input name="titulo" value="{{ old('titulo') }}" type="text">
        @error('titulo')
            <span>{{ $message }}</span>
        @enderror
        <input type="file" name="archivo" id="archivo" value="{{ old('archivo') }}" accept="application/pdf">
        @error('archivo')
            <span>{{ $message }}</span>
        @enderror
        <input type="submit" value="Guardar">
    </form>
@endsection
