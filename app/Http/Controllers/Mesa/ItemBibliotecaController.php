<?php

namespace App\Http\Controllers\Mesa;

use App\Enums\TipoItemBiblioteca;
use App\Http\Controllers\Controller;
use App\Http\Requests\Biblioteca\AtualizarItemRequest;
use App\Http\Requests\Biblioteca\SalvarItemRequest;
use App\Models\Campanha;
use App\Models\ItemBiblioteca;
use App\Servicos\Biblioteca\ArvoreDaBiblioteca;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ItemBibliotecaController extends Controller
{
    public function salvar(SalvarItemRequest $request, Campanha $campanha): RedirectResponse
    {
        $dados = $request->validated();

        $item = new ItemBiblioteca();
        $item->campanha_id = $campanha->id;
        $item->pasta_id = $this->idDaPasta($dados);
        $item->tipo = TipoItemBiblioteca::from($dados['tipo']);
        $item->nome = $dados['nome'];
        $item->visivel_para_jogadores = $request->boolean('visivel_para_jogadores');
        $item->dono_id = $request->user()->id;
        $item->ordem = $this->proximaOrdem($campanha, $item->pasta_id);
        $item->conteudo = $item->ehPasta() ? null : ['texto' => ''];
        $item->save();

        // a anotação já abre para escrever; a pasta só aparece na árvore
        if ($item->ehPasta()) {
            return redirect()->route('mesa.exibir', $campanha)
                ->with('sucesso', 'Pasta criada.');
        }

        return redirect()->route('biblioteca.exibir', [$campanha, $item])
            ->with('sucesso', 'Anotação criada.');
    }

    /** Abre um item no centro da mesa. */
    public function exibir(Request $request, Campanha $campanha, ItemBiblioteca $item, ArvoreDaBiblioteca $arvore): View
    {
        $this->garantirQuePertence($campanha, $item);
        Gate::authorize('ver', $item);

        $ehMestre = $campanha->ehMestre($request->user());
        $raizes = $arvore->montar($campanha, $ehMestre);

        // uma pasta não pode ser movida para dentro dela mesma
        $ignorar = $item->ehPasta() ? $item->idsDaSubarvore() : [];

        return view('mesa.parciais.novo-item', [
            'campanha' => $campanha->load('membros'),
            'ehMestre' => $ehMestre,
            'arvore' => $raizes,
            'pastas' => $arvore->pastasParaSelecao($raizes),
            'pastasDestino' => $arvore->pastasParaSelecao($raizes, $ignorar),
            'selecionado' => $item,
        ]);
    }

    /** Renomeia, move, muda a visibilidade e salva o texto. Permissão no AtualizarItemRequest. */
    public function atualizar(AtualizarItemRequest $request, Campanha $campanha, ItemBiblioteca $item): RedirectResponse
    {
        $dados = $request->validated();
        $novaPasta = $this->idDaPasta($dados);

        if ($novaPasta !== $item->pasta_id) {
            $item->pasta_id = $novaPasta;
            $item->ordem = $this->proximaOrdem($campanha, $novaPasta);   // vai para o fim da nova pasta
        }

        $item->nome = $dados['nome'];
        $item->visivel_para_jogadores = $request->boolean('visivel_para_jogadores');

        if (! $item->ehPasta()) {
            $item->conteudo = ['texto' => $dados['texto'] ?? ''];
        }

        $item->save();

        return redirect()->route('biblioteca.exibir', [$campanha, $item])
            ->with('sucesso', $item->ehPasta() ? 'Pasta atualizada.' : 'Anotação salva.');
    }

    public function excluir(Campanha $campanha, ItemBiblioteca $item): RedirectResponse
    {
        $this->garantirQuePertence($campanha, $item);
        Gate::authorize('excluir', $item);

        $eraPasta = $item->ehPasta();
        $item->delete();   // o cascade da chave pasta_id apaga o que estava dentro

        return redirect()->route('mesa.exibir', $campanha)
            ->with('sucesso', $eraPasta ? 'Pasta excluída com tudo o que havia dentro.' : 'Anotação excluída.');
    }

    /** O item da URL precisa ser da campanha da URL; senão, é como se não existisse. */
    private function garantirQuePertence(Campanha $campanha, ItemBiblioteca $item): void
    {
        abort_unless($item->campanha_id === $campanha->id, 404);
    }

    /** O formulário manda o id como texto ("3") ou vazio; aqui vira inteiro ou nulo (raiz). */
    private function idDaPasta(array $dados): ?int
    {
        return isset($dados['pasta_id']) ? (int) $dados['pasta_id'] : null;
    }

    /** Posição seguinte à do último item da pasta (ou da raiz, quando $pastaId é nulo). */
    private function proximaOrdem(Campanha $campanha, ?int $pastaId): int
    {
        $ultima = ItemBiblioteca::query()->where('campanha_id', $campanha->id)
            ->where('pasta_id', $pastaId)
            ->max('ordem');

        return (int) $ultima + 1;
    }
}
