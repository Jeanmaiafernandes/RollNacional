<?php

namespace App\Servicos\Fichas;

use App\Enums\TipoCampo;
use Illuminate\Validation\Rule;

/**
 * Gera as regras do validador a partir da estrutura.
 * Os inputs chegam como valores[chave], valores[chave][atual|maximo] e valores[chave][i][sub].
 */
class RegrasDeValidacao
{
    public function para(EstruturaFicha $estrutura): array
    {
        $regras = ['valores' => ['nullable', 'array']];

        foreach ($estrutura->camposComEntrada() as $campo) {
            $chave = 'valores.'.$campo['chave'];
            $regras = $regras + $this->regrasDoCampo($chave, $estrutura->tipoDe($campo), $campo);
        }

        return $regras;
    }

    /** Nomes amigáveis para as mensagens de erro. */
    public function atributos(EstruturaFicha $estrutura): array
    {
        $nomes = [];

        foreach ($estrutura->camposComEntrada() as $campo) {
            $chave = 'valores.'.$campo['chave'];
            $rotulo = $campo['rotulo'] ?? $campo['chave'];
            $nomes[$chave] = $rotulo;
            $nomes[$chave.'.atual'] = $rotulo.' (atual)';
            $nomes[$chave.'.maximo'] = $rotulo.' (máximo)';

            foreach ($campo['subcampos'] ?? [] as $sub) {
                $nomes[$chave.'.*.'.$sub['chave']] = $rotulo.' › '.($sub['rotulo'] ?? $sub['chave']);
            }
        }

        return $nomes;
    }

    private function regrasDoCampo(string $chave, TipoCampo $tipo, array $campo): array
    {
        $obrigatorio = ($campo['obrigatorio'] ?? false) ? 'required' : 'nullable';

        return match ($tipo) {
            TipoCampo::Texto => [$chave => [$obrigatorio, 'string', 'max:255']],
            TipoCampo::TextoLongo => [$chave => [$obrigatorio, 'string', 'max:20000']],
            TipoCampo::Numero => [$chave => array_filter([
                $obrigatorio, 'integer',
                isset($campo['minimo']) ? 'min:'.$campo['minimo'] : null,
                isset($campo['maximo']) ? 'max:'.$campo['maximo'] : null,
            ])],
            TipoCampo::Recurso => [
                $chave => ['nullable', 'array'],
                $chave.'.atual' => ['nullable', 'integer'],
                $chave.'.maximo' => ['nullable', 'integer', 'min:0'],
            ],
            TipoCampo::Selecao => [$chave => [$obrigatorio, Rule::in($campo['opcoes'] ?? [])]],
            TipoCampo::Lista => $this->regrasDaLista($chave, $campo),
            TipoCampo::Rolagem => [],
        };
    }

    private function regrasDaLista(string $chave, array $campo): array
    {
        $regras = [
            $chave => ['nullable', 'array', 'max:'.($campo['maximo_itens'] ?? 100)],
            $chave.'.*.id' => ['nullable', 'string', 'max:40'],
            $chave.'.*._remover' => ['nullable', 'boolean'],
        ];

        foreach ($campo['subcampos'] ?? [] as $sub) {
            $subChave = $chave.'.*.'.$sub['chave'];
            $tipoSub = TipoCampo::tryFrom($sub['tipo'] ?? '') ?? TipoCampo::Texto;

            $regras[$subChave] = match ($tipoSub) {
                TipoCampo::Numero => ['nullable', 'integer'],
                TipoCampo::Selecao => ['nullable', Rule::in($sub['opcoes'] ?? [])],
                default => ['nullable', 'string', 'max:255'],
            };
        }

        return $regras;
    }
}
