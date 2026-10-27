<?php

namespace App\Enums;

enum Visibilidade: string
{
    case Oculto = 'oculto';          // só mestre e co-mestre
    case Todos = 'todos';            // todos os participantes
    case Especifico = 'especifico';  // lista em item_biblioteca_usuario

    public function rotulo(): string
    {
        return match ($this) {
            self::Oculto => 'Oculto',
            self::Todos => 'Todos',
            self::Especifico => 'Participantes específicos',
        };
    }
}
