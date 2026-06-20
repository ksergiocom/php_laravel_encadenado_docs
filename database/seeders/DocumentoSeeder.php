<?php

namespace Database\Seeders;

use App\Enums\Estados;
use App\Models\Documento;
use App\Models\User;
use App\Services\DocumentoEventoService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentoSeeder extends Seeder
{
    use WithoutModelEvents;

    public function __construct(private DocumentoEventoService $eventoService) {}

    /**
     * Seed documentos y sus eventos encadenados para desarrollo.
     *
     * Genera la mayoría de documentos publicados (normales), un par
     * sustituidos por una versión posterior y uno retirado, replicando
     * los flujos reales de DocumentoController para mantener válida la
     * cadena de hashes de DocumentoEvento.
     */
    public function run(): void
    {
        $autores = User::factory()->count(3)->create();

        $fecha = Carbon::create(2026, 1, 10, 9, 0, 0);

        $titulosNormales = [
            'Política de Privacidad',
            'Términos y Condiciones',
            'Manual de Usuario',
            'Política de Cookies',
            'Código de Conducta',
            'Guía de Estilo',
            'Plan de Contingencia',
        ];

        foreach ($titulosNormales as $titulo) {
            $this->publicar($titulo, $autores->random(), $fecha->copy());
            $this->avanzar($fecha);
        }

        $reglamento = $this->publicar('Reglamento Interno', $autores->random(), $fecha->copy());
        $this->avanzar($fecha);

        $protocolo = $this->publicar('Protocolo de Seguridad', $autores->random(), $fecha->copy());
        $this->avanzar($fecha);

        $avisoLegal = $this->publicar('Aviso Legal Antiguo', $autores->random(), $fecha->copy());
        $this->avanzar($fecha);

        $this->sustituir($reglamento, $autores->random(), $fecha->copy());
        $this->avanzar($fecha);

        $this->sustituir($protocolo, $autores->random(), $fecha->copy());
        $this->avanzar($fecha);

        $this->retirar($avisoLegal, $autores->random(), $fecha->copy());

        Carbon::setTestNow(null);
        Auth::logout();
    }

    private function publicar(string $titulo, User $autor, Carbon $fecha): Documento
    {
        Auth::login($autor);
        Carbon::setTestNow($fecha);

        $slug = Str::slug($titulo);
        $version = 1;
        $path = $this->guardarPdfDummy($slug, $version, $titulo);

        $documento = new Documento;
        $documento->titulo = $titulo;
        $documento->slug = $slug;
        $documento->version = $version;
        $documento->estado = Estados::PUBLICADO;
        $documento->path = $path;
        $documento->file_hash = $this->eventoService->calcularHashArchivo($path);
        $documento->publicado_at = now();
        $documento->publicado_por_usuario_id = $autor->id;
        $documento->save();

        $this->eventoService->registrar(
            tipo: Estados::PUBLICADO->value,
            documento: $documento,
            documentoPrevio: null,
            request: null,
        );

        return $documento;
    }

    private function sustituir(Documento $original, User $autor, Carbon $fecha): Documento
    {
        Auth::login($autor);
        Carbon::setTestNow($fecha);

        $nuevaVersion = $original->version + 1;
        $path = $this->guardarPdfDummy($original->slug, $nuevaVersion, $original->titulo);

        $documentoNuevo = new Documento;
        $documentoNuevo->titulo = $original->titulo;
        $documentoNuevo->slug = $original->slug;
        $documentoNuevo->version = $nuevaVersion;
        $documentoNuevo->estado = Estados::PUBLICADO;
        $documentoNuevo->path = $path;
        $documentoNuevo->file_hash = $this->eventoService->calcularHashArchivo($path);
        $documentoNuevo->publicado_at = now();
        $documentoNuevo->publicado_por_usuario_id = $autor->id;
        $documentoNuevo->sustituye_a_documento_id = $original->id;
        $documentoNuevo->save();

        $original->estado = Estados::SUSTITUIDO;
        $original->retirado_at = now();
        $original->retirado_por_usuario_id = $autor->id;
        $original->sustituido_por_documento_id = $documentoNuevo->id;
        $original->save();

        $this->eventoService->registrar(
            tipo: Estados::SUSTITUIDO->value,
            documento: $documentoNuevo,
            documentoPrevio: $original,
            request: null,
            extraPayload: [
                'accion_sobre_documento_anterior' => [
                    'id' => $original->id,
                    'estado' => $original->estado,
                    'retirado_at' => $original->retirado_at?->toISOString(),
                    'retirado_por_usuario_id' => $original->retirado_por_usuario_id,
                ],
            ],
        );

        return $documentoNuevo;
    }

    private function retirar(Documento $documento, User $autor, Carbon $fecha): void
    {
        Auth::login($autor);
        Carbon::setTestNow($fecha);

        $documento->estado = Estados::RETIRADO;
        $documento->retirado_at = now();
        $documento->retirado_por_usuario_id = $autor->id;
        $documento->save();

        $this->eventoService->registrar(
            tipo: Estados::RETIRADO->value,
            documento: $documento,
            documentoPrevio: null,
            request: null,
        );
    }

    private function guardarPdfDummy(string $slug, int $version, string $titulo): string
    {
        $path = 'documentos/'.$slug.'-v'.$version.'.pdf';

        Storage::disk('public')->put($path, $this->pdfDummy($titulo.' (v'.$version.')'));

        return $path;
    }

    private function pdfDummy(string $titulo): string
    {
        $texto = str_replace(['(', ')', '\\'], ['[', ']', '/'], $titulo);

        $contenido = 'BT /F1 18 Tf 50 700 Td ('.$texto.') Tj ET';

        return implode("\n", [
            '%PDF-1.4',
            '1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj',
            '2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj',
            '3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >> endobj',
            '4 0 obj << /Length '.strlen($contenido).' >>',
            'stream',
            $contenido,
            'endstream endobj',
            '5 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj',
            'trailer << /Root 1 0 R >>',
            '%%EOF',
        ]);
    }

    private function avanzar(Carbon $fecha): void
    {
        $fecha->addDays(random_int(2, 6))->addHours(random_int(0, 5));
    }
}
