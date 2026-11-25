<?php

namespace App\Http\Controllers\Sistema;

use App\Http\Controllers\Controller;
use App\Models\Sistema;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SistemaController extends Controller
{
    /** Filtros da estante: valor da coluna "origem" => texto do botão */
    private const ORIGENS = [
        'nacional' => 'Nacionais',
        'independente' => 'Independentes',
        'estrangeiro' => 'Estrangeiros',
    ];

    public function index(Request $request): View
    {
        $origem = $request->string('origem')->toString();
        $origem = array_key_exists($origem, self::ORIGENS) ? $origem : null;

        $sistemas = Sistema::publicados()
            ->when($origem, fn ($consulta) => $consulta->where('origem', $origem))
            ->orderBy('nome')
            ->get();

        return view('sistemas.index', [
            'sistemas' => $sistemas,
            'origens' => self::ORIGENS,
            'origem' => $origem,
        ]);
    }

    public function show(Sistema $sistema): View
    {
        abort_unless($sistema->publicado, 404);

        return view('sistemas.show', ['sistema' => $sistema]);
    }
}
