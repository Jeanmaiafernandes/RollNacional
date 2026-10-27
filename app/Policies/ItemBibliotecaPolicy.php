<?php

namespace App\Policies;

use App\Models\Campanha;
use App\Models\ItemBiblioteca;
use App\Models\Usuario;

/**
 * Regras desta primeira versão: o mestre organiza a biblioteca,
 * e os jogadores só leem o que está visível para eles.
 */
class ItemBibliotecaPolicy
{
    public function criar(Usuario $usuario, Campanha $campanha): bool
    {
        return $campanha->ehMestre($usuario);
    }

    public function ver(Usuario $usuario, ItemBiblioteca $item): bool
    {
        $campanha = $item->campanha;

        if ($campanha->ehMestre($usuario)) {
            return true;
        }

        return $campanha->participa($usuario) && $item->visivelParaJogadores();
    }

    public function atualizar(Usuario $usuario, ItemBiblioteca $item): bool
    {
        return $item->campanha->ehMestre($usuario);
    }

    public function excluir(Usuario $usuario, ItemBiblioteca $item): bool
    {
        return $item->campanha->ehMestre($usuario);
    }
}
