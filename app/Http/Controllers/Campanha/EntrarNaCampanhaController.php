<?php

namespace App\Http\Controllers\Campanha;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campanha\EntrarNaCampanhaRequest;
use App\Servicos\Campanha\EntradaNaCampanha;
use Illuminate\Http\RedirectResponse;

class EntrarNaCampanhaController extends Controller
{
    public function __invoke(EntrarNaCampanhaRequest $request, EntradaNaCampanha $entrada): RedirectResponse
    {
        $dados = $request->validated();

        $campanha = $entrada->entrar($dados['codigo_convite'], $dados['senha'], $request->user());

        return redirect()->route('campanhas.exibir', $campanha)
            ->with('sucesso', 'Você entrou na campanha como espectador. O mestre pode promover você a jogador.');
    }
}
