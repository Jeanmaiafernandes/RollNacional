<?php

namespace App\Http\Controllers\Campanha;

use App\Http\Controllers\Controller;
use App\Models\Campanha;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SairDaCampanhaController extends Controller
{
    public function __invoke(Request $request, Campanha $campanha): RedirectResponse
    {
        Gate::authorize('sair', $campanha);

        $campanha->membros()->detach($request->user()->id);

        return redirect()->route('inicio')
            ->with('sucesso', 'Você saiu da campanha '.$campanha->nome.'.');
    }
}
