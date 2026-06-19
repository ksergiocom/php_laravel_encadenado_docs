<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Documento extends Model
{
    protected $table = 'documentos';

    protected $fillable = [
        'estado',
        'titulo',
        'path',
        'file_hash',
        'slug',
        'version',
        'publicado_at',
        'retirado_at',
        'publicado_por_usuario_id',
        'retirado_por_usuario_id',
        'sustituye_a_documento_id',
        'sustituido_por_documento_id',
    ];

    protected $casts = [
        'publicado_at' => 'datetime',
        'retirado_at' => 'datetime',
    ];

    public function getFileNameAttribute()
    {
        return basename($this->path);
    }

    public function sustituyeADocumento()
    {
        return $this->belongsTo(Documento::class, 'sustituye_a_documento_id');
    }

    public function sustituidoPorDocumento()
    {
        return $this->belongsTo(Documento::class, 'sustituido_por_documento_id');
    }

    public function publicadoPorUsuario()
    {
        return $this->belongsTo(User::class, 'publicado_por_usuario_id');
    }

    public function retiradoPorUsuario()
    {
        return $this->belongsTo(User::class, 'retirado_por_usuario_id');
    }

    public function eventos()
    {
        return $this->hasMany(DocumentoEvento::class);
    }

    public function hashValido(): bool
    {
        if (! $this->path || ! Storage::disk('public')->exists($this->path)) {
            return false;
        }

        $hashActual = hash_file(
            'sha256',
            Storage::disk('public')->path($this->path)
        );

        return hash_equals($this->file_hash, $hashActual);
    }
}