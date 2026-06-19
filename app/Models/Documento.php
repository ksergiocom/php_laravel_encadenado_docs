<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documentos';

    protected $fillable = [
        'estado',
        'titulo',
        'path',
        'slug',
        'version',
        'publicado_at',
        'retirado_at',
        'publicado_por_usuario_id',
        'retirado_por_usuario_id',
        'sustituye_a_documento_id',
        'sustituido_por_documento_id',
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
        return $this->belongsTo(User::class, 'publicado_por_id');
    }

    public function retiradoPorUsuario()
    {
        return $this->belongsTo(User::class, 'retirado_por_id');
    }
}
