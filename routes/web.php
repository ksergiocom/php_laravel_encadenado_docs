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
    Route::get('/admin/{documento}/retirar', [DocumentoController::class, 'retirar'])->name('admin.retirar');
    Route::resource('admin', DocumentoController::class)
        ->parameters(['admin' => 'documento'])
        ->names('admin');
});
