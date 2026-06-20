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

    public function __construct(private DocumentoEventoService $eventoService)
    {
    }

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
            'Acta de la Junta General Ordinaria de Accionistas de la Sociedad Anónima Correspondiente al Ejercicio Social 2023, Celebrada el 30 de Junio de 2024',
            'Acta de la Junta General Extraordinaria de Accionistas de la Sociedad Anónima Celebrada el 15 de Marzo de 2024 para la Adopción de Acuerdos Sociales',
            'Certificación de los Acuerdos Adoptados por la Junta General de Accionistas en Relación con el Ejercicio Social Cerrado a 31 de Diciembre de 2023',
            'Informe del Consejo de Administración sobre la Gestión Social, Económica y Patrimonial del Ejercicio 2023',
            'Propuesta de Aplicación del Resultado Correspondiente al Ejercicio Social Cerrado el 31 de Diciembre de 2023',
            'Acta de Aprobación de las Cuentas Anuales, Informe de Gestión y Propuesta de Aplicación del Resultado del Ejercicio 2023',
            'Documento de Convocatoria de Junta General Ordinaria de Accionistas para la Aprobación de las Cuentas Anuales del Ejercicio 2023',
            'Acta de Nombramiento, Reelección o Cese de Miembros del Consejo de Administración con Fecha 20 de Mayo de 2024',
            'Certificación del Acuerdo de Modificación Parcial de los Estatutos Sociales Adoptado en Junta General Extraordinaria de 10 de Abril de 2024',
            'Acta de Delegación de Facultades para la Formalización, Ejecución e Inscripción de Acuerdos Sociales Adoptados durante el Ejercicio 2024',
            'Informe Justificativo del Consejo de Administración sobre la Ampliación de Capital Social Acordada el 25 de Septiembre de 2024',
            'Acta de Aprobación de Operaciones Societarias de Especial Relevancia Correspondientes al Ejercicio Social 2024',
            'Certificación de Titularidad, Representación y Derechos de Voto de Accionistas a Fecha 31 de Diciembre de 2023',
            'Acta de Constitución de la Mesa de la Junta General Ordinaria de Accionistas Celebrada el 28 de Junio de 2024',
            'Relación de Accionistas Presentes, Representados y Derechos de Voto en la Junta General Ordinaria del Ejercicio 2023',
            'Documento de Elevación a Público de los Acuerdos Sociales Adoptados en Junta General de Accionistas de Fecha 30 de Junio de 2024',
            'Certificación del Libro de Actas de la Sociedad Anónima Correspondiente al Periodo Comprendido entre 2023 y 2024',
        ];

        foreach ($titulosNormales as $titulo) {
            $this->publicar($titulo, $autores->random(), $fecha->copy());
            $this->avanzar($fecha);
        }

        $reglamento = $this->publicar('Informe sobre la Situación Económica, Financiera y Patrimonial de la Sociedad Correspondiente al Ejercicio Cerrado a 31 de Diciembre de 2023', $autores->random(), $fecha->copy());
        $this->avanzar($fecha);

        $protocolo = $this->publicar('Acta de Aprobación del Presupuesto Anual y Plan de Actuación Societaria para el Ejercicio 2025', $autores->random(), $fecha->copy());
        $this->avanzar($fecha);

        $avisoLegal = $this->publicar('Acta de Ratificación de Acuerdos Adoptados por el Órgano de Administración durante el Primer Semestre del Ejercicio 2024', $autores->random(), $fecha->copy());
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
        $path = 'documentos/' . $slug . '-v' . $version . '.pdf';

        Storage::disk('public')->put($path, $this->pdfDummy($titulo . ' (v' . $version . ')'));

        return $path;
    }

    private function pdfDummy(string $titulo): string
    {
        $texto = str_replace(['(', ')', '\\'], ['[', ']', '/'], $titulo);

        $contenido = 'BT /F1 18 Tf 50 700 Td (' . $texto . ') Tj ET';

        return implode("\n", [
            '%PDF-1.4',
            '1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj',
            '2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj',
            '3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >> endobj',
            '4 0 obj << /Length ' . strlen($contenido) . ' >>',
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
