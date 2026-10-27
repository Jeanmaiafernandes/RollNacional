<?php

namespace App\Servicos\Biblioteca;

use App\Models\Campanha;
use App\Models\ItemBiblioteca;
use Illuminate\Support\Collection;

/**
 * Monta a árvore da biblioteca de uma campanha com uma única consulta ao banco.
 */
class ArvoreDaBiblioteca
{
    /**
     * Devolve os itens da raiz; cada pasta já vem com a relação "filhos" preenchida.
     * Para jogadores, itens ocultos ficam de fora junto com tudo o que está dentro deles.
     *
     * @return Collection<int, ItemBiblioteca>
     */
    public function montar(Campanha $campanha, bool $ehMestre): Collection
    {
        $itens = ItemBiblioteca::query()->where('campanha_id', $campanha->id)->get();

        if (! $ehMestre) {
            $itens = $itens->where('visivel_para_jogadores', true);
        }

        // pastas primeiro, depois a ordem definida, depois o nome
        $itens = $itens->sortBy(fn (ItemBiblioteca $item) => [
            $item->ehPasta() ? 0 : 1,
            $item->ordem,
            mb_strtolower($item->nome),
        ]);

        // chave 0 = itens da raiz (pasta_id nulo)
        $porPasta = $itens->groupBy(fn (ItemBiblioteca $item) => $item->pasta_id ?? 0);

        $anexarFilhos = function (ItemBiblioteca $item) use (&$anexarFilhos, $porPasta): void {
            $filhos = $porPasta->get($item->id, collect())->values();
            $filhos->each($anexarFilhos);

            $item->setRelation('filhos', $filhos);
        };

        $raizes = $porPasta->get(0, collect())->values();
        $raizes->each($anexarFilhos);

        return $raizes;
    }

    /**
     * Lista as pastas na ordem da árvore, com o nome recuado, para usar num <select>.
     * $ignorar recebe ids que não podem ser escolhidos (a própria pasta e o que está dentro dela).
     *
     * @param  Collection<int, ItemBiblioteca>  $itens
     * @param  array<int, int>  $ignorar
     * @return array<int, array{id: int, rotulo: string}>
     */
    public function pastasParaSelecao(Collection $itens, array $ignorar = [], int $nivel = 0): array
    {
        $pastas = [];

        foreach ($itens as $item) {
            if (! $item->ehPasta() || in_array($item->id, $ignorar, true)) {
                continue;
            }

            $pastas[] = [
                'id' => $item->id,
                'rotulo' => str_repeat('— ', $nivel).$item->nome,
            ];

            array_push($pastas, ...$this->pastasParaSelecao($item->filhos, $ignorar, $nivel + 1));
        }

        return $pastas;
    }
}
