<?php

namespace App\Policies;

use App\Models\SistemaJogo;
use App\Models\Usuario;

class SistemaJogoPolicy
{
    /** Lista e página do sistema: qualquer logado vê os publicados; admin vê todos. */
    public function ver(Usuario $usuario, SistemaJogo $sistema): bool
    {
        return $sistema->estaPublicado() || $usuario->administrador;
    }

    public function administrar(Usuario $usuario): bool
    {
        return $usuario->administrador;
    }
}
