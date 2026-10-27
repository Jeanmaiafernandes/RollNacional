<?php

namespace App\Enums;

enum StatusSistema: string
{
    case Rascunho = 'rascunho';
    case Publicado = 'publicado';
    case Descontinuado = 'descontinuado';
}
