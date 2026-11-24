<?php

namespace App\Http\Controllers\Sistema;

use App\Http\Controllers\Controller;
use App\Models\Sistema;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class SistemaController extends Controller
{
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

    public function show(string $sistema): View
    {
        $sistema = $this->catalogo()->firstWhere('slug', $sistema) ?? abort(404);

        return view('sistemas.show', ['sistema' => $sistema]);
    }

    /**
     * Texto fixo até a tabela "sistemas" ficar pronta.
     * Depois, troque por Sistema::orderBy('nome')->get() e Sistema::where('slug', ...)->firstOrFail():
     * as views já usam os mesmos nomes de campo (slug, nome, sigla, editora, cor, capa...).
     */
    private function catalogo(): Collection
    {
        return collect([
            (object) [
                'slug' => 'tormenta20',
                'nome' => 'Tormenta20',
                'sigla' => 'T20',
                'editora' => 'Jambô Editora',
                'cor' => '#8a2a2e',
                'capa' => 'img/sistemas/capa-tormenta20.webp',
                'capa_alt' => 'Capa de Tormenta20 com o grupo de heróis do livro básico',
                'capa_posicao' => 'center 22%',
                'resumo' => 'O maior RPG brasileiro, ambientado em Arton. Atributos, perícias, poderes e magias crescem a cada nível, e a ficha acompanha tudo.',
                'sobre' => [
                    'Tormenta20 é o RPG de fantasia mais jogado do Brasil. Os heróis enfrentam a Tormenta, uma tempestade rubra que corrompe tudo o que toca, num mundo cheio de deuses, reinos e masmorras.',
                    'As rolagens usam um d20 somado a atributos e perícias. Cada classe ganha poderes a cada nível, e boa parte do jogo está em montar a combinação certa.',
                ],
                'para_jogar' => [
                    'De três a seis pessoas, uma delas como mestre.',
                    'Um d20 e alguns dados de dano.',
                    'Uma ficha por personagem.',
                    'O livro básico, ou o compêndio daqui.',
                ],
                'recursos' => [
                    'Atributos, perícias e defesa recalculados a cada mudança.',
                    'PV e PM acompanhados direto na ficha.',
                    'Classes e poderes ligados ao compêndio.',
                ],
                'situacao' => [
                    'Ficha que calcula sozinha' => 'em construção',
                    'Compêndio de regras' => 'em transcrição',
                    'Mesa virtual' => 'etapa 2',
                ],
                'ficha_tecnica' => [
                    'Editora' => 'Jambô',
                    'Lançamento' => '2020',
                    'Dado' => 'd20',
                    'Atributos' => 'For · Des · Con · Int · Sab · Car',
                    'Recursos' => 'PV e PM',
                ],
            ],
            (object) [
                'slug' => 'dnd-5e',
                'nome' => 'D&D 5e',
                'sigla' => '5E',
                'editora' => 'Wizards of the Coast',
                'cor' => '#244a72',
                'capa' => 'img/sistemas/capa-dnd5e.webp',
                'capa_alt' => 'Arte de D&D 5e com aventureiros e dragões',
                'capa_posicao' => 'center 30%',
                'resumo' => 'O clássico de fantasia com masmorras e dragões. Ficha com proficiências, salvaguardas e espaços de magia calculados.',
                'sobre' => [
                    'Dungeons & Dragons é o RPG de fantasia mais conhecido do mundo. Um grupo de aventureiros explora masmorras, enfrenta dragões e cresce em nível a cada aventura.',
                    'As rolagens usam um d20 somado ao modificador do atributo e, quando o personagem é proficiente, ao bônus de proficiência. Vantagem e desvantagem trocam os modificadores por uma segunda rolagem.',
                ],
                'para_jogar' => [
                    'De três a seis pessoas, uma delas como mestre.',
                    'Um conjunto de dados, do d4 ao d20.',
                    'Uma ficha por personagem.',
                    'O Livro do Jogador, ou as regras básicas gratuitas.',
                ],
                'recursos' => [
                    'Modificadores, salvaguardas e proficiências calculados.',
                    'Espaços de magia para marcar durante a sessão.',
                    'Perícias ligadas aos atributos da ficha.',
                ],
                'situacao' => [
                    'Ficha que calcula sozinha' => 'em construção',
                    'Compêndio de regras' => 'em transcrição',
                    'Mesa virtual' => 'etapa 2',
                ],
                'ficha_tecnica' => [
                    'Editora' => 'Wizards of the Coast',
                    'Lançamento' => '2014',
                    'Dado' => 'd20',
                    'Atributos' => 'For · Des · Con · Int · Sab · Car',
                    'Recursos' => 'PV e espaços de magia',
                ],
            ],
        ]);
    }
}
