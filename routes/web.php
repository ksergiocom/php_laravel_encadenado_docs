<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DocumentoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/documentos/{documento}', [DocumentoController::class, 'download'])->name('documentos.download');

Route::get('/admin/{documento}/retirar', [DocumentoController::class, 'retirar'])->name('admin.retirar');
Route::resource('admin', DocumentoController::class)->parameters(['admin' => 'documento'])->names('admin');