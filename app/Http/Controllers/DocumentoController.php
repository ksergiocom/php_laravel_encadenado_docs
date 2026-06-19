<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Documento;
use App\Enums\Estados;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentos = Documento::all();

        return view('admin.index', [
            'documentos' => $documentos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string'],
            'archivo' => ['required', 'file', 'mimes:pdf', 'max:51200'], // 50MB máximo!
        ]);

        // Datos basicos
        $titulo = $validated['titulo'];
        $slug = Str::slug($titulo);
        $version = 1;

        // Guardando el fichero
        $filename = $slug . '-v' . $version . '.pdf';
        $path = $request->file('archivo')->storeAs('documentos', $filename, 'public');

        // Guradando en DB
        $documento = new Documento();

        $documento->titulo = $titulo;
        $documento->slug = $slug;
        $documento->version = $version;
        $documento->estado = Estados::PUBLICADO;
        $documento->path = $path;
        $documento->publicado_at = now();

        $documento->save();

        return redirect()->route('admin.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Documento $documento)
    {
        return view('admin.edit', [
            'documento' => $documento,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Documento $documento)
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string'],
            'archivo' => ['required', 'file', 'mimes:pdf', 'max:51200'], // 50MB máximo!
        ]);

        DB::transaction(function () use ($request, $validated, $documento) {
            // Para generar el nuevo nombre de fichero
            $titulo = $validated['titulo'];
            $slug = Str::slug($titulo);
            $nuevaVersion = $documento->version + 1;
            $filename = $slug . '-v' . $nuevaVersion . '.pdf';
            $path = $request->file('archivo')->storeAs('documentos', $filename, 'public');

            // Guradando en DB el nuevo
            $documentoNuevo = new Documento();

            $documentoNuevo->titulo = $titulo;
            $documentoNuevo->slug = $slug;
            $documentoNuevo->version = $nuevaVersion;
            $documentoNuevo->estado = Estados::PUBLICADO;
            $documentoNuevo->path = $path;
            $documentoNuevo->publicado_at = now();
            $documentoNuevo->sustituye_a_id = $documento->id;

            $documentoNuevo->save();

            // El viejo se marca como sustituido
            $documento->estado = Estados::SUSTITUIDO;
            $documento->retirado_at = now();
            $documento->sustituido_por_id = $documentoNuevo->id;
            $documento->save();
        });

        return redirect()->route('admin.index');
    }

    public function retirar(Documento $documento)
    {
        $documento->estado = Estados::RETIRADO;
        $documento->retirado_at = now();
        $documento->save();

        return redirect()->route('admin.index');
    }

}
