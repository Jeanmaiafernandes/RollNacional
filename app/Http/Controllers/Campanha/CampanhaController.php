<?php

namespace App\Http\Controllers\Campanha;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campanha\AtualizarCampanhaRequest;
use App\Http\Requests\Campanha\SalvarCampanhaRequest;
use App\Models\Campanha;
use App\Models\SistemaJogo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CampanhaController extends Controller
{
    public function listar(Request $request): View
    {
        $campanhas = $request->user()
            ->campanhas()
            ->with('sistema')
            ->latest('campanhas.created_at')
            ->get();

        return view('inicio', [
            'campanhas' => $campanhas,
        ]);
    }

    public function criar(): View
    {
        return view('campanhas.criar', [
            'campanha' => new Campanha(),
            'sistemas' => SistemaJogo::query()->publicados()->orderBy('nome')->get(),
        ]);
    }

    /**
     * O booted() do model gera o código, põe o mestre na pivot e cria a pasta fixa.
     * Aqui só se preenchem os campos.
     */
    public function salvar(SalvarCampanhaRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $campanha = new Campanha();
        $campanha->mestre_id = $request->user()->id;
        $campanha->sistema_jogo_id = $dados['sistema_jogo_id'];
        $campanha->nome = $dados['nome'];
        $campanha->descricao = $dados['descricao'] ?? null;
        $campanha->senha = $dados['senha'];
        $campanha->save();

        return redirect()->route('campanhas.exibir', $campanha)
            ->with('sucesso', 'Campanha criada. Passe o código de convite e a senha para os jogadores.');
    }

    public function exibir(Request $request, Campanha $campanha): View
    {
        Gate::authorize('ver', $campanha);

        $campanha->load(['sistema', 'mestre', 'membros' => fn ($q) => $q->orderBy('nome')]);

        return view('campanhas.exibir', [
            'campanha' => $campanha,
            'papel' => $campanha->papelDe($request->user()),
            'ehMestre' => $campanha->ehMestre($request->user()),
        ]);
    }

    public function editar(Campanha $campanha): View
    {
        Gate::authorize('atualizar', $campanha);

        return view('campanhas.editar', [
            'campanha' => $campanha->load('sistema'),
        ]);
    }

    public function atualizar(AtualizarCampanhaRequest $request, Campanha $campanha): RedirectResponse
    {
        $dados = $request->validated();

        $campanha->nome = $dados['nome'];
        $campanha->descricao = $dados['descricao'] ?? null;

        if (! empty($dados['senha'])) {
            $campanha->senha = $dados['senha'];
        }

        $campanha->save();

        return redirect()->route('campanhas.exibir', $campanha)
            ->with('sucesso', 'Campanha atualizada.');
    }

    public function excluir(Campanha $campanha): RedirectResponse
    {
        Gate::authorize('excluir', $campanha);

        $campanha->delete();

        return redirect()->route('inicio')
            ->with('sucesso', 'Campanha excluída.');
    }
}
