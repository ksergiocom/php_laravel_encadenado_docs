<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentoController;
use App\Models\Documento;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $documentos = Documento::all();

    return view('welcome', [
        'documentos' => $documentos,
    ]);
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/documentos/{documento}', [DocumentoController::class, 'download'])->name('documentos.download');

Route::middleware('auth')->group(function () {
    Route::get('/admin/publicar', [DocumentoController::class, 'confirmarPublicacion'])->name('admin.publicar');
    Route::get('/admin/{documento}/retirar', [DocumentoController::class, 'confirmarRetiro'])->name('admin.retirar');
    Route::post('/admin/{documento}/retirar', [DocumentoController::class, 'retirar'])->name('admin.retirar.ejecutar');
    Route::get('/admin/{documento}/sustituir', [DocumentoController::class, 'confirmarSustitucion'])->name('admin.sustituir');
    Route::resource('admin', DocumentoController::class)
        ->parameters(['admin' => 'documento'])
        ->names('admin');
});
