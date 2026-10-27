<?php

namespace App\Enums;

enum PapelCampanha: string
{
    case Mestre = 'mestre';
    case CoMestre = 'co_mestre';
    case Jogador = 'jogador';
    case Espectador = 'espectador';

    public function rotulo(): string
    {
        return match ($this) {
            self::Mestre => 'Mestre',
            self::CoMestre => 'Co-mestre',
            self::Jogador => 'Jogador',
            self::Espectador => 'Espectador',
        };
    }

    public function ehMestreOuCoMestre(): bool
    {
        return $this === self::Mestre || $this === self::CoMestre;
    }

    public function podeRolar(): bool
    {
        return $this !== self::Espectador;
    }

    public function podeEscrever(): bool
    {
        return $this !== self::Espectador;
    }

    public function podeTerFicha(): bool
    {
        return $this !== self::Espectador;
    }

    /** Papéis que mestre/co-mestre podem atribuir a outro participante. */
    public static function atribuiveis(): array
    {
        return [self::CoMestre, self::Jogador, self::Espectador];
    }

    public static function valoresAtribuiveis(): array
    {
        return array_map(fn (self $p) => $p->value, self::atribuiveis());
    }
}
