<?php

namespace App\Enums;

enum StatusVersao: string
{
    case Rascunho = 'rascunho';
    case Publicada = 'publicada';
    case Obsoleta = 'obsoleta';
}
