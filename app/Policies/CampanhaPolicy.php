<?php

namespace App\Policies;

use App\Enums\PapelCampanha;
use App\Models\Campanha;
use App\Models\Usuario;

class CampanhaPolicy
{
    public function ver(Usuario $usuario, Campanha $campanha): bool
    {
        return $campanha->participa($usuario);
    }

    /** Editar dados, redefinir senha: só o Mestre. */
    public function atualizar(Usuario $usuario, Campanha $campanha): bool
    {
        return $campanha->ehMestre($usuario);
    }

    public function excluir(Usuario $usuario, Campanha $campanha): bool
    {
        return $campanha->ehMestre($usuario);
    }

    /** Mudar papel, pode_criar_itens e expulsar: mestre ou co-mestre (nunca sobre o Mestre; o serviço garante). */
    public function gerirParticipantes(Usuario $usuario, Campanha $campanha): bool
    {
        return $campanha->ehMestreOuCoMestre($usuario);
    }

    /** O Mestre não sai: exclui. */
    public function sair(Usuario $usuario, Campanha $campanha): bool
    {
        return $campanha->participa($usuario) && ! $campanha->ehMestre($usuario);
    }

    public function escrever(Usuario $usuario, Campanha $campanha): bool
    {
        $papel = $campanha->papelDe($usuario);

        if ($papel === null) {
            return false;
        }

        return $papel->podeEscrever() || $campanha->espectador_pode_escrever;
    }

    public function rolar(Usuario $usuario, Campanha $campanha): bool
    {
        return $campanha->papelDe($usuario)?->podeRolar() ?? false;
    }

    public function rolarSecreto(Usuario $usuario, Campanha $campanha): bool
    {
        return $campanha->ehMestreOuCoMestre($usuario);
    }

    /** Jogador ou acima: pode ter ficha PJ e importar personagens da conta. */
    public function terFicha(Usuario $usuario, Campanha $campanha): bool
    {
        return $campanha->papelDe($usuario)?->podeTerFicha() ?? false;
    }
}
