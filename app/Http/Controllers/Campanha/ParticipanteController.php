<?php

namespace App\Http\Controllers\Campanha;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campanha\AtualizarParticipanteRequest;
use App\Models\Campanha;
use App\Models\Usuario;
use App\Servicos\Campanha\GestorDePapeis;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use InvalidArgumentException;

/** Tela de participantes da campanha: papel, permissão de criar itens e expulsão. */
class ParticipanteController extends Controller
{
    public function __construct(private readonly GestorDePapeis $gestor)
    {
    }

    public function atualizar(AtualizarParticipanteRequest $request, Campanha $campanha, Usuario $usuario): RedirectResponse
    {
        try {
            $this->gestor->definirPapel($campanha, $usuario, $request->papel(), $request->podeCriarItens());
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['participante' => $e->getMessage()]);
        }

        return redirect()->route('campanhas.exibir', $campanha)
            ->with('sucesso', $usuario->nome.' agora é '.$request->papel()->rotulo().'.');
    }

    public function expulsar(Campanha $campanha, Usuario $usuario): RedirectResponse
    {
        Gate::authorize('gerirParticipantes', $campanha);

        try {
            $this->gestor->expulsar($campanha, $usuario);
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['participante' => $e->getMessage()]);
        }

        return redirect()->route('campanhas.exibir', $campanha)
            ->with('sucesso', $usuario->nome.' foi removido da campanha. As fichas dele continuam na mesa.');
    }
}
