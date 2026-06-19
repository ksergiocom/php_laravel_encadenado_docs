<?php

namespace App\Enums;

enum Estados: string
{
    case PUBLICADO = 'publicado';
    case SUSTITUIDO = 'sustituido';
    case RETIRADO = 'retirado';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}