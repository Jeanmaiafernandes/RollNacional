<?php

namespace App\Servicos\Fichas;

use App\Enums\TipoCampo;

/**
 * Objeto de valor que envolve o JSON de estrutura de UM tipo de ficha (pj ou npc).
 *
 * Formato esperado:
 * {
 *   "secoes": [
 *     { "chave": "atributos", "titulo": "Atributos", "campos": [
 *       { "chave": "agilidade", "tipo": "numero", "rotulo": "Agilidade", "padrao": 1, "minimo": 0, "maximo": 5 },
 *       { "chave": "pv", "tipo": "recurso", "rotulo": "Pontos de Vida" },
 *       { "chave": "classe", "tipo": "selecao", "rotulo": "Classe", "opcoes": ["Combatente", "Especialista"] },
 *       { "chave": "pericias", "tipo": "lista", "rotulo": "Perícias", "subcampos": [ {...}, {...} ] },
 *       { "chave": "teste_agi", "tipo": "rolagem", "rotulo": "Teste de Agilidade", "expressao": "@{agilidade}d20kh1" },
 *       { "chave": "descricao", "tipo": "texto_longo", "rotulo": "Descrição", "publico": true }
 *     ]}
 *   ]
 * }
 */
final class EstruturaFicha
{
    /** @param array<int, array> $secoes */
    private function __construct(private readonly array $secoes)
    {
    }

    public static function deArray(array $estrutura): self
    {
        return new self($estrutura['secoes'] ?? []);
    }

    /** @return array<int, array> */
    public function secoes(): array
    {
        return $this->secoes;
    }

    /** Todos os campos, de todas as seções, achatados. */
    public function campos(): array
    {
        $campos = [];
        foreach ($this->secoes as $secao) {
            foreach ($secao['campos'] ?? [] as $campo) {
                $campos[] = $campo;
            }
        }

        return $campos;
    }

    /** Só os campos que guardam valor (exclui "rolagem"). */
    public function camposComEntrada(): array
    {
        return array_values(array_filter(
            $this->campos(),
            fn (array $campo) => $this->tipoDe($campo)->guardaValor()
        ));
    }

    /** Campos que jogadores veem numa ficha NPC revelada. */
    public function camposPublicos(): array
    {
        return array_values(array_filter(
            $this->campos(),
            fn (array $campo) => (bool) ($campo['publico'] ?? false)
        ));
    }

    public function campo(string $chave): ?array
    {
        foreach ($this->campos() as $campo) {
            if (($campo['chave'] ?? null) === $chave) {
                return $campo;
            }
        }

        return null;
    }

    public function tipoDe(array $campo): TipoCampo
    {
        return TipoCampo::tryFrom($campo['tipo'] ?? '') ?? TipoCampo::Texto;
    }

    public function estaVazia(): bool
    {
        return $this->campos() === [];
    }
}
