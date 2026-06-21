<?php

namespace App\Http\Controllers;

use App\Models\DocumentoEvento;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = DocumentoEvento::query()
            ->with(['documento', 'usuario'])
            ->orderByDesc('id')
            ->get();

        return view('admin.eventos.index', [
            'eventos' => $eventos,
        ]);
    }

    public function show(DocumentoEvento $evento)
    {
        $evento->load(['documento', 'documentoPrevio', 'usuario']);

        return view('admin.eventos.show', [
            'evento' => $evento,
        ]);
    }
}
