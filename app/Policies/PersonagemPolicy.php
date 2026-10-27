<?php

namespace App\Policies;

use App\Models\Personagem;
use App\Models\Usuario;

class PersonagemPolicy
{
    public function ver(Usuario $usuario, Personagem $personagem): bool
    {
        return $personagem->usuario_id === $usuario->id;
    }

    public function atualizar(Usuario $usuario, Personagem $personagem): bool
    {
        return $personagem->usuario_id === $usuario->id;
    }

    public function excluir(Usuario $usuario, Personagem $personagem): bool
    {
        return $personagem->usuario_id === $usuario->id;
    }
}
