<?php

namespace App\Servicos\Campanha;

use App\Enums\PapelCampanha;
use App\Models\Campanha;
use App\Models\Usuario;
use InvalidArgumentException;

/** Promove, rebaixa e expulsa participantes. Nunca toca no Mestre. */
class GestorDePapeis
{
    public function definirPapel(Campanha $campanha, Usuario $alvo, PapelCampanha $papel, bool $podeCriarItens): void
    {
        $this->garantirQueNaoEhOMestre($campanha, $alvo);

        if (! in_array($papel, PapelCampanha::atribuiveis(), true)) {
            throw new InvalidArgumentException('Papel não atribuível.');
        }

        if (! $campanha->participa($alvo)) {
            throw new InvalidArgumentException('Usuário não participa da campanha.');
        }

        $campanha->membros()->updateExistingPivot($alvo->id, [
            'papel' => $papel->value,
            'pode_criar_itens' => $papel->ehMestreOuCoMestre() ? true : $podeCriarItens,
        ]);
    }

    /** Fichas e itens do expulso ficam na mesa (são cópias); só a pivot sai. */
    public function expulsar(Campanha $campanha, Usuario $alvo): void
    {
        $this->garantirQueNaoEhOMestre($campanha, $alvo);

        $campanha->membros()->detach($alvo->id);
    }

    private function garantirQueNaoEhOMestre(Campanha $campanha, Usuario $alvo): void
    {
        if ($campanha->ehMestre($alvo)) {
            throw new InvalidArgumentException('O Mestre da campanha não pode ser alterado nem removido.');
        }
    }
}
