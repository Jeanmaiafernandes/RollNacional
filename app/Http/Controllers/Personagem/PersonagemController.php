<?php

namespace App\Http\Controllers\Personagem;

use App\Enums\TipoFicha;
use App\Http\Controllers\Controller;
use App\Http\Requests\Personagem\AtualizarPersonagemRequest;
use App\Http\Requests\Personagem\SalvarPersonagemRequest;
use App\Models\Personagem;
use App\Models\SistemaJogo;
use App\Servicos\Fichas\MontadorDeFicha;
use App\Servicos\Fichas\NormalizadorDeValores;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PersonagemController extends Controller
{
    public function __construct(
        private readonly MontadorDeFicha $montador,
        private readonly NormalizadorDeValores $normalizador,
    ) {
    }

    public function listar(Request $request): View
    {
        $personagens = $request->user()
            ->personagens()
            ->with('sistema')
            ->orderBy('nome')
            ->get();

        return view('personagens.listar', [
            'personagens' => $personagens->where('tipo', TipoFicha::Pj),
            'npcs' => $personagens->where('tipo', TipoFicha::Npc),
            'sistemas' => SistemaJogo::query()->publicados()->orderBy('nome')->get(),
        ]);
    }

    /** GET /personagens/criar?sistema=ordem-paranormal&tipo=pj */
    public function criar(Request $request): View
    {
        $sistema = SistemaJogo::query()->publicados()->where('slug', $request->query('sistema'))->firstOrFail();
        $tipo = TipoFicha::tryFrom((string) $request->query('tipo', 'pj')) ?? TipoFicha::Pj;
        $estrutura = $sistema->estruturaAtual($tipo);

        return view('personagens.criar', [
            'sistema' => $sistema,
            'tipo' => $tipo,
            'estrutura' => $estrutura,
            'valores' => old('valores', $this->montador->valoresPadrao($estrutura)),
        ]);
    }

    public function salvar(SalvarPersonagemRequest $request): RedirectResponse
    {
        $dados = $request->validated();
        $sistema = $request->sistema();
        $tipo = $request->tipo();
        $estrutura = $sistema->estruturaAtual($tipo);

        $personagem = new Personagem();
        $personagem->usuario_id = $request->user()->id;
        $personagem->sistema_jogo_id = $sistema->id;
        $personagem->tipo = $tipo;
        $personagem->nome = $dados['nome'];
        $personagem->valores = $this->normalizador->normalizar(
            $estrutura,
            $this->montador->valoresPadrao($estrutura),
            $dados['valores'] ?? [],
        );
        $personagem->save();

        return redirect()->route('personagens.exibir', $personagem)
            ->with('sucesso', $tipo === TipoFicha::Npc ? 'NPC criado.' : 'Personagem criado.');
    }

    public function exibir(Personagem $personagem): View
    {
        Gate::authorize('ver', $personagem);

        return view('personagens.exibir', [
            'personagem' => $personagem->load('sistema'),
            'estrutura' => $personagem->estrutura(),
            'valores' => old('valores', $personagem->valores),
        ]);
    }

    public function atualizar(AtualizarPersonagemRequest $request, Personagem $personagem): RedirectResponse
    {
        $dados = $request->validated();

        $personagem->nome = $dados['nome'];
        $personagem->valores = $this->normalizador->normalizar(
            $personagem->estrutura(),
            $personagem->valores ?? [],
            $dados['valores'] ?? [],
        );
        $personagem->save();

        return redirect()->route('personagens.exibir', $personagem)
            ->with('sucesso', 'Alterações salvas.');
    }

    public function excluir(Personagem $personagem): RedirectResponse
    {
        Gate::authorize('excluir', $personagem);

        $personagem->delete();

        return redirect()->route('personagens.listar')
            ->with('sucesso', 'Personagem excluído.');
    }
}
