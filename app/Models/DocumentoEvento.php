<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoEvento extends Model
{
    protected $table = 'documento_eventos';

    public $timestamps = false;

    protected $fillable = [
        'documento_id',
        'tipo',
        'usuario_id',
        'documento_file_hash',
        'documento_previo_id',
        'documento_previo_file_hash',
        'previous_event_hash',
        'event_hash',
        'payload',
        'ip',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'created_at' => 'datetime',
    ];

    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }

    public function documentoPrevio()
    {
        return $this->belongsTo(Documento::class, 'documento_previo_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}