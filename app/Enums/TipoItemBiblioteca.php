<?php

namespace App\Enums;

enum TipoItemBiblioteca: string
{
    case Pasta = 'pasta';
    case Anotacao = 'anotacao';
    case Ficha = 'ficha';
    case Cena = 'cena';
    case Imagem = 'imagem';

    public function rotulo(): string
    {
        return match ($this) {
            self::Pasta => 'Pasta',
            self::Anotacao => 'Anotação',
            self::Ficha => 'Ficha',
            self::Cena => 'Cena',
            self::Imagem => 'Imagem',
        };
    }

    public function podeConterItens(): bool
    {
        return $this === self::Pasta;
    }
}
