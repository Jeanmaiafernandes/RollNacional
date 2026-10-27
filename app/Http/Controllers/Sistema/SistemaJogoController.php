<?php

namespace App\Http\Controllers\Sistema;

use App\Enums\StatusSistema;
use App\Http\Controllers\Controller;
use App\Models\SistemaJogo;
use Illuminate\View\View;

class SistemaJogoController extends Controller
{
    public function listar(): View
    {
        return view('sistemas.listar', [
            'sistemas' => SistemaJogo::publicados()->orderBy('nome')->get(),
        ]);
    }

    public function exibir(SistemaJogo $sistema): View
    {
        abort_unless($sistema->status === StatusSistema::Publicado, 404);

        return view('sistemas.exibir', [
            'sistema' => $sistema->load('versaoAtual'),
        ]);
    }
}
