<?php

namespace App\Services;

use App\Models\Documento;
use App\Models\DocumentoEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoEventoService
{
    public function registrar(
        string $tipo,
        Documento $documento,
        ?Documento $documentoPrevio = null,
        ?Request $request = null,
        array $extraPayload = []
    ): DocumentoEvento {
        $previousEventHash = DocumentoEvento::query()
            ->orderByDesc('id')
            ->lockForUpdate()
            ->value('event_hash');

        $createdAt = now();

        $documentoFileHash = $documento->file_hash;

        $documentoPrevioFileHash = $documentoPrevio?->file_hash;

        $payload = [
            'tipo' => $tipo,
            'documento' => [
                'id' => $documento->id,
                'titulo' => $documento->titulo,
                'slug' => $documento->slug,
                'version' => $documento->version,
                'estado' => $documento->estado instanceof \BackedEnum
                    ? $documento->estado->value
                    : $documento->estado,
                'path' => $documento->path,
                'file_hash' => $documentoFileHash,
                'publicado_at' => $documento->publicado_at?->toISOString(),
                'retirado_at' => $documento->retirado_at?->toISOString(),
                'publicado_por_usuario_id' => $documento->publicado_por_usuario_id,
                'retirado_por_usuario_id' => $documento->retirado_por_usuario_id,
                'sustituye_a_documento_id' => $documento->sustituye_a_documento_id,
                'sustituido_por_documento_id' => $documento->sustituido_por_documento_id,
            ],
            'documento_previo' => $documentoPrevio ? [
                'id' => $documentoPrevio->id,
                'titulo' => $documentoPrevio->titulo,
                'slug' => $documentoPrevio->slug,
                'version' => $documentoPrevio->version,
                'estado' => $documentoPrevio->estado instanceof \BackedEnum
                    ? $documentoPrevio->estado->value
                    : $documentoPrevio->estado,
                'path' => $documentoPrevio->path,
                'file_hash' => $documentoPrevioFileHash,
                'publicado_at' => $documentoPrevio->publicado_at?->toISOString(),
                'retirado_at' => $documentoPrevio->retirado_at?->toISOString(),
            ] : null,
            'extra' => $extraPayload,
        ];

        $hashInput = [
            'documento_id' => $documento->id,
            'tipo' => $tipo,
            'usuario_id' => auth()->id(),
            'documento_file_hash' => $documentoFileHash,
            'documento_previo_id' => $documentoPrevio?->id,
            'documento_previo_file_hash' => $documentoPrevioFileHash,
            'previous_event_hash' => $previousEventHash,
            'payload' => $payload,
            'ip' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'created_at' => $createdAt->toISOString(),
        ];

        $eventHash = $this->hashEvento($hashInput);

        return DocumentoEvento::create([
            'documento_id' => $documento->id,
            'tipo' => $tipo,
            'usuario_id' => auth()->id(),
            'documento_file_hash' => $documentoFileHash,
            'documento_previo_id' => $documentoPrevio?->id,
            'documento_previo_file_hash' => $documentoPrevioFileHash,
            'previous_event_hash' => $previousEventHash,
            'event_hash' => $eventHash,
            'payload' => $payload,
            'ip' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'created_at' => $createdAt,
        ]);
    }

    private function hashEvento(array $data): string
    {
        return hash_hmac(
            'sha256',
            json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            config('app.evidence_key')
        );
    }

    public function calcularHashArchivo(string $path): string
    {
        return hash_file(
            'sha256',
            Storage::disk('public')->path($path)
        );
    }

    public function verificarCadena(): bool
    {
        $previousHash = null;

        $eventos = DocumentoEvento::query()
            ->orderBy('id')
            ->get();

        foreach ($eventos as $evento) {
            if ($evento->previous_event_hash !== $previousHash) {
                return false;
            }

            $hashInput = [
                'documento_id' => $evento->documento_id,
                'tipo' => $evento->tipo,
                'usuario_id' => $evento->usuario_id,
                'documento_file_hash' => $evento->documento_file_hash,
                'documento_previo_id' => $evento->documento_previo_id,
                'documento_previo_file_hash' => $evento->documento_previo_file_hash,
                'previous_event_hash' => $evento->previous_event_hash,
                'payload' => $evento->payload,
                'ip' => $evento->ip,
                'user_agent' => $evento->user_agent,
                'created_at' => $evento->created_at->toISOString(),
            ];

            $expectedHash = $this->hashEvento($hashInput);

            if (!hash_equals($expectedHash, $evento->event_hash)) {
                return false;
            }

            $previousHash = $evento->event_hash;
        }

        return true;
    }
}