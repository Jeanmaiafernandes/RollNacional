<?php

namespace Database\Seeders;

use App\Enums\StatusSistema;
use App\Enums\StatusVersao;
use App\Models\SistemaJogo;
use Illuminate\Database\Seeder;

/**
 * Cadastra Ordem Paranormal (agente + ameaça) e o sistema Livre.
 * Só termos de regra; nenhum texto protegido por direitos autorais.
 * Idempotente: roda de novo sem duplicar (updateOrCreate pelo slug).
 */
class SistemaJogoSeeder extends Seeder
{
    public function run(): void
    {
        $this->cadastrar(
            dados: [
                'nome' => 'Ordem Paranormal RPG',
                'slug' => 'ordem-paranormal',
                'editora' => 'Jambô Editora',
                'descricao' => 'Horror e investigação. Agentes da Ordo Realitas enfrentam o Outro Lado.',
                'site_oficial' => 'https://ordemparanormal.com.br',
                'aviso_licenca' => 'Ordem Paranormal RPG é marca da Jambô Editora. Esta ficha reproduz apenas termos de regra.',
                'status' => StatusSistema::Publicado,
            ],
            estruturas: [
                'pj' => $this->ordemAgente(),
                'npc' => $this->ordemAmeaca(),
            ],
        );

        $this->cadastrar(
            dados: [
                'nome' => 'Livre',
                'slug' => 'livre',
                'editora' => null,
                'descricao' => 'Ficha mínima para qualquer jogo ainda não cadastrado: texto livre e atributos à escolha.',
                'site_oficial' => null,
                'aviso_licenca' => null,
                'status' => StatusSistema::Publicado,
            ],
            estruturas: [
                'pj' => $this->livre(),
                'npc' => $this->livre(),
            ],
        );
    }

    private function cadastrar(array $dados, array $estruturas): void
    {
        $sistema = SistemaJogo::query()->firstOrNew(['slug' => $dados['slug']]);
        $sistema->nome = $dados['nome'];
        $sistema->slug = $dados['slug'];
        $sistema->editora = $dados['editora'];
        $sistema->descricao = $dados['descricao'];
        $sistema->site_oficial = $dados['site_oficial'];
        $sistema->aviso_licenca = $dados['aviso_licenca'];
        $sistema->status = $dados['status'];
        $sistema->save();

        $versao = $sistema->versoes()->firstOrNew(['numero' => '1.0']);
        $versao->estruturas = $estruturas;
        $versao->notas_alteracao = 'Versão inicial.';
        $versao->status = StatusVersao::Publicada;
        $versao->publicada_em ??= now();
        $versao->save();
    }

    // ---------------------------------------------------------------- Ordem

    private function atributosOrdem(): array
    {
        $atributo = fn (string $chave, string $rotulo) => [
            'chave' => $chave, 'tipo' => 'numero', 'rotulo' => $rotulo,
            'padrao' => 1, 'minimo' => 0, 'maximo' => 5,
        ];

        return [
            'chave' => 'atributos', 'titulo' => 'Atributos',
            'campos' => [
                $atributo('agilidade', 'Agilidade'),
                $atributo('forca', 'Força'),
                $atributo('intelecto', 'Intelecto'),
                $atributo('presenca', 'Presença'),
                $atributo('vigor', 'Vigor'),
            ],
        ];
    }

    private function testesOrdem(): array
    {
        $teste = fn (string $chave, string $rotulo) => [
            'chave' => 'teste_'.$chave, 'tipo' => 'rolagem',
            'rotulo' => 'Teste de '.$rotulo, 'expressao' => '@{'.$chave.'}d20kh1',
        ];

        return [
            'chave' => 'testes', 'titulo' => 'Testes de atributo',
            'campos' => [
                $teste('agilidade', 'Agilidade'),
                $teste('forca', 'Força'),
                $teste('intelecto', 'Intelecto'),
                $teste('presenca', 'Presença'),
                $teste('vigor', 'Vigor'),
            ],
        ];
    }

    private function ordemAgente(): array
    {
        return ['secoes' => [
            [
                'chave' => 'identidade', 'titulo' => 'Identidade',
                'campos' => [
                    ['chave' => 'jogador', 'tipo' => 'texto', 'rotulo' => 'Jogador'],
                    ['chave' => 'origem', 'tipo' => 'texto', 'rotulo' => 'Origem'],
                    ['chave' => 'classe', 'tipo' => 'selecao', 'rotulo' => 'Classe',
                        'opcoes' => ['Combatente', 'Especialista', 'Ocultista'], 'obrigatorio' => true],
                    ['chave' => 'trilha', 'tipo' => 'texto', 'rotulo' => 'Trilha'],
                    ['chave' => 'nex', 'tipo' => 'numero', 'rotulo' => 'NEX (%)', 'padrao' => 5, 'minimo' => 5, 'maximo' => 99],
                    ['chave' => 'patente', 'tipo' => 'selecao', 'rotulo' => 'Patente',
                        'opcoes' => ['Recruta', 'Operador', 'Agente especial', 'Oficial de operações', 'Agente de elite']],
                ],
            ],
            $this->atributosOrdem(),
            [
                'chave' => 'recursos', 'titulo' => 'Recursos',
                'campos' => [
                    ['chave' => 'pv', 'tipo' => 'recurso', 'rotulo' => 'Pontos de Vida'],
                    ['chave' => 'pe', 'tipo' => 'recurso', 'rotulo' => 'Pontos de Esforço'],
                    ['chave' => 'san', 'tipo' => 'recurso', 'rotulo' => 'Sanidade'],
                    ['chave' => 'defesa', 'tipo' => 'numero', 'rotulo' => 'Defesa', 'padrao' => 10],
                    ['chave' => 'deslocamento', 'tipo' => 'numero', 'rotulo' => 'Deslocamento (m)', 'padrao' => 9],
                ],
            ],
            [
                'chave' => 'pericias', 'titulo' => 'Perícias',
                'campos' => [
                    ['chave' => 'pericias', 'tipo' => 'lista', 'rotulo' => 'Perícias',
                        'subcampos' => [
                            ['chave' => 'nome', 'tipo' => 'texto', 'rotulo' => 'Perícia'],
                            ['chave' => 'treinamento', 'tipo' => 'selecao', 'rotulo' => 'Treinamento',
                                'opcoes' => ['Destreinado', 'Treinado', 'Veterano', 'Expert']],
                            ['chave' => 'bonus', 'tipo' => 'numero', 'rotulo' => 'Bônus'],
                        ]],
                ],
            ],
            [
                'chave' => 'combate', 'titulo' => 'Ataques',
                'campos' => [
                    ['chave' => 'ataques', 'tipo' => 'lista', 'rotulo' => 'Ataques',
                        'subcampos' => [
                            ['chave' => 'nome', 'tipo' => 'texto', 'rotulo' => 'Arma'],
                            ['chave' => 'teste', 'tipo' => 'texto', 'rotulo' => 'Teste'],
                            ['chave' => 'dano', 'tipo' => 'texto', 'rotulo' => 'Dano'],
                            ['chave' => 'critico', 'tipo' => 'texto', 'rotulo' => 'Crítico'],
                        ]],
                ],
            ],
            [
                'chave' => 'inventario', 'titulo' => 'Inventário',
                'campos' => [
                    ['chave' => 'itens', 'tipo' => 'lista', 'rotulo' => 'Itens',
                        'subcampos' => [
                            ['chave' => 'nome', 'tipo' => 'texto', 'rotulo' => 'Item'],
                            ['chave' => 'categoria', 'tipo' => 'numero', 'rotulo' => 'Categoria'],
                            ['chave' => 'espacos', 'tipo' => 'numero', 'rotulo' => 'Espaços'],
                        ]],
                    ['chave' => 'prestigio', 'tipo' => 'numero', 'rotulo' => 'Pontos de Prestígio', 'padrao' => 0],
                ],
            ],
            [
                'chave' => 'habilidades', 'titulo' => 'Habilidades e rituais',
                'campos' => [
                    ['chave' => 'habilidades', 'tipo' => 'texto_longo', 'rotulo' => 'Habilidades'],
                    ['chave' => 'rituais', 'tipo' => 'texto_longo', 'rotulo' => 'Rituais'],
                ],
            ],
            [
                'chave' => 'historia', 'titulo' => 'História',
                'campos' => [
                    ['chave' => 'aparencia', 'tipo' => 'texto_longo', 'rotulo' => 'Aparência', 'publico' => true],
                    ['chave' => 'historia', 'tipo' => 'texto_longo', 'rotulo' => 'História'],
                ],
            ],
            $this->testesOrdem(),
        ]];
    }

    private function ordemAmeaca(): array
    {
        return ['secoes' => [
            [
                'chave' => 'identidade', 'titulo' => 'Ameaça',
                'campos' => [
                    ['chave' => 'tipo', 'tipo' => 'selecao', 'rotulo' => 'Tipo',
                        'opcoes' => ['Humano', 'Criatura', 'Objeto', 'Espírito'], 'obrigatorio' => true],
                    ['chave' => 'vd', 'tipo' => 'numero', 'rotulo' => 'VD (Valor de Desafio)', 'padrao' => 5, 'minimo' => 0],
                    ['chave' => 'elemento', 'tipo' => 'selecao', 'rotulo' => 'Elemento',
                        'opcoes' => ['Nenhum', 'Conhecimento', 'Energia', 'Morte', 'Sangue', 'Medo']],
                    ['chave' => 'aparencia', 'tipo' => 'texto_longo', 'rotulo' => 'Aparência', 'publico' => true],
                ],
            ],
            $this->atributosOrdem(),
            [
                'chave' => 'recursos', 'titulo' => 'Recursos',
                'campos' => [
                    ['chave' => 'pv', 'tipo' => 'recurso', 'rotulo' => 'Pontos de Vida'],
                    ['chave' => 'defesa', 'tipo' => 'numero', 'rotulo' => 'Defesa', 'padrao' => 10],
                    ['chave' => 'deslocamento', 'tipo' => 'numero', 'rotulo' => 'Deslocamento (m)', 'padrao' => 9],
                    ['chave' => 'resistencias', 'tipo' => 'texto', 'rotulo' => 'Resistências'],
                    ['chave' => 'perturbacao', 'tipo' => 'numero', 'rotulo' => 'Presença Perturbadora (DT)', 'padrao' => 0],
                ],
            ],
            [
                'chave' => 'pericias', 'titulo' => 'Perícias',
                'campos' => [
                    ['chave' => 'pericias', 'tipo' => 'lista', 'rotulo' => 'Perícias',
                        'subcampos' => [
                            ['chave' => 'nome', 'tipo' => 'texto', 'rotulo' => 'Perícia'],
                            ['chave' => 'bonus', 'tipo' => 'numero', 'rotulo' => 'Bônus'],
                        ]],
                ],
            ],
            [
                'chave' => 'combate', 'titulo' => 'Ataques',
                'campos' => [
                    ['chave' => 'ataques', 'tipo' => 'lista', 'rotulo' => 'Ataques',
                        'subcampos' => [
                            ['chave' => 'nome', 'tipo' => 'texto', 'rotulo' => 'Ataque'],
                            ['chave' => 'teste', 'tipo' => 'texto', 'rotulo' => 'Teste'],
                            ['chave' => 'dano', 'tipo' => 'texto', 'rotulo' => 'Dano'],
                        ]],
                ],
            ],
            [
                'chave' => 'habilidades', 'titulo' => 'Habilidades',
                'campos' => [
                    ['chave' => 'habilidades', 'tipo' => 'texto_longo', 'rotulo' => 'Habilidades'],
                    ['chave' => 'notas_mestre', 'tipo' => 'texto_longo', 'rotulo' => 'Notas do mestre'],
                ],
            ],
            $this->testesOrdem(),
        ]];
    }

    // ---------------------------------------------------------------- Livre

    private function livre(): array
    {
        return ['secoes' => [
            [
                'chave' => 'geral', 'titulo' => 'Geral',
                'campos' => [
                    ['chave' => 'conceito', 'tipo' => 'texto', 'rotulo' => 'Conceito', 'publico' => true],
                    ['chave' => 'descricao', 'tipo' => 'texto_longo', 'rotulo' => 'Descrição', 'publico' => true],
                ],
            ],
            [
                'chave' => 'atributos', 'titulo' => 'Atributos',
                'campos' => [
                    ['chave' => 'atributos', 'tipo' => 'lista', 'rotulo' => 'Atributos',
                        'subcampos' => [
                            ['chave' => 'nome', 'tipo' => 'texto', 'rotulo' => 'Atributo'],
                            ['chave' => 'valor', 'tipo' => 'texto', 'rotulo' => 'Valor'],
                        ]],
                    ['chave' => 'pv', 'tipo' => 'recurso', 'rotulo' => 'Vida'],
                ],
            ],
            [
                'chave' => 'anotacoes', 'titulo' => 'Anotações',
                'campos' => [
                    ['chave' => 'anotacoes', 'tipo' => 'texto_longo', 'rotulo' => 'Anotações'],
                ],
            ],
        ]];
    }
}
