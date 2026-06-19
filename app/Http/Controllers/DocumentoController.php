<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\Documento;
use App\Enums\Estados;
use App\Services\DocumentoEventoService;

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

    public function store(Request $request, DocumentoEventoService $eventoService)
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string'],
            'archivo' => ['required', 'file', 'mimes:pdf', 'max:51200'],
        ]);

        $path = null;

        try {
            $titulo = $validated['titulo'];
            $slug = Str::slug($titulo);
            $version = 1;

            $filename = $slug . '-v' . $version . '.pdf';

            $path = $request->file('archivo')->storeAs(
                'documentos',
                $filename,
                'public'
            );

            DB::transaction(function () use ($titulo, $slug, $version, $path, $request, $eventoService) {
                $fileHash = $eventoService->calcularHashArchivo($path);

                $documento = new Documento();

                $documento->titulo = $titulo;
                $documento->slug = $slug;
                $documento->version = $version;
                $documento->estado = Estados::PUBLICADO;
                $documento->path = $path;
                $documento->file_hash = $fileHash;
                $documento->publicado_at = now();
                $documento->publicado_por_usuario_id = auth()->id();

                $documento->save();

                $eventoService->registrar(
                    tipo: 'publicado',
                    documento: $documento,
                    documentoPrevio: null,
                    request: $request
                );
            });

            return redirect()->route('admin.index');

        } catch (\Throwable $e) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }

            throw $e;
        }
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

    public function update(
        Request $request,
        Documento $documento,
        DocumentoEventoService $eventoService
    ) {
        $validated = $request->validate([
            'titulo' => ['required', 'string'],
            'archivo' => ['required', 'file', 'mimes:pdf', 'max:51200'],
        ]);

        $path = null;

        try {
            $titulo = $validated['titulo'];
            $slug = Str::slug($titulo);
            $nuevaVersion = $documento->version + 1;

            $filename = $slug . '-v' . $nuevaVersion . '.pdf';

            $path = $request->file('archivo')->storeAs(
                'documentos',
                $filename,
                'public'
            );

            DB::transaction(function () use ($titulo, $slug, $nuevaVersion, $path, $documento, $request, $eventoService) {
                $fileHash = $eventoService->calcularHashArchivo($path);

                $documentoNuevo = new Documento();

                $documentoNuevo->titulo = $titulo;
                $documentoNuevo->slug = $slug;
                $documentoNuevo->version = $nuevaVersion;
                $documentoNuevo->estado = Estados::PUBLICADO;
                $documentoNuevo->path = $path;
                $documentoNuevo->file_hash = $fileHash;
                $documentoNuevo->publicado_at = now();
                $documentoNuevo->publicado_por_usuario_id = auth()->id();
                $documentoNuevo->sustituye_a_documento_id = $documento->id;

                $documentoNuevo->save();

                $documento->estado = Estados::SUSTITUIDO;
                $documento->retirado_at = now();
                $documento->retirado_por_usuario_id = auth()->id();
                $documento->sustituido_por_documento_id = $documentoNuevo->id;

                $documento->save();

                $eventoService->registrar(
                    tipo: 'sustituido',
                    documento: $documentoNuevo,
                    documentoPrevio: $documento,
                    request: $request,
                    extraPayload: [
                        'accion_sobre_documento_anterior' => [
                            'id' => $documento->id,
                            'estado' => $documento->estado,
                            'retirado_at' => $documento->retirado_at?->toISOString(),
                            'retirado_por_usuario_id' => $documento->retirado_por_usuario_id,
                        ],
                    ]
                );
            });

            return redirect()->route('admin.index');

        } catch (\Throwable $e) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }

            throw $e;
        }
    }

    public function retirar(
        Request $request,
        Documento $documento,
        DocumentoEventoService $eventoService
    ) {
        DB::transaction(function () use ($documento, $request, $eventoService) {
            $documento->estado = Estados::RETIRADO;
            $documento->retirado_at = now();
            $documento->retirado_por_usuario_id = auth()->id();

            $documento->save();

            $eventoService->registrar(
                tipo: 'retirado',
                documento: $documento,
                documentoPrevio: null,
                request: $request
            );
        });

        return redirect()->route('admin.index');
    }

}
