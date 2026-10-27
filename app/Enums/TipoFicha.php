<?php

namespace App\Enums;

enum TipoFicha: string
{
    case Pj = 'pj';
    case Npc = 'npc';

    public function rotulo(): string
    {
        return match ($this) {
            self::Pj => 'Personagem',
            self::Npc => 'NPC / ameaça',
        };
    }
}
