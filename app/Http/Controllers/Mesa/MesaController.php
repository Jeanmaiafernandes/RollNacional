<?php

namespace App\Http\Controllers\Mesa;

use App\Http\Controllers\Controller;
use App\Models\Campanha;
use App\Servicos\Biblioteca\ArvoreDaBiblioteca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class MesaController extends Controller
{
    /** A mesa da campanha: biblioteca à esquerda e, no centro, o espaço do tabuleiro. */
    public function exibir(Request $request, Campanha $campanha, ArvoreDaBiblioteca $arvore): View
    {
        Gate::authorize('ver', $campanha);

        $ehMestre = $campanha->ehMestre($request->user());
        $raizes = $arvore->montar($campanha, $ehMestre);

        return view('mesa.exibir', [
            'campanha' => $campanha->load('membros'),
            'ehMestre' => $ehMestre,
            'arvore' => $raizes,
            'pastas' => $arvore->pastasParaSelecao($raizes),
            'selecionado' => null,
        ]);
    }
}
