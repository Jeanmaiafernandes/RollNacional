<?php

namespace App\Servicos\Fichas;

use App\Enums\TipoCampo;

/** Monta o array "valores" de uma ficha nova a partir da estrutura. */
class MontadorDeFicha
{
    public function valoresPadrao(EstruturaFicha $estrutura): array
    {
        $valores = [];

        foreach ($estrutura->camposComEntrada() as $campo) {
            $valores[$campo['chave']] = $this->padraoDoCampo($estrutura->tipoDe($campo), $campo);
        }

        return $valores;
    }

    public function padraoDoCampo(TipoCampo $tipo, array $campo): mixed
    {
        return match ($tipo) {
            TipoCampo::Texto, TipoCampo::TextoLongo => (string) ($campo['padrao'] ?? ''),
            TipoCampo::Numero => (int) ($campo['padrao'] ?? 0),
            TipoCampo::Recurso => [
                'atual' => (int) ($campo['padrao'] ?? 0),
                'maximo' => (int) ($campo['padrao'] ?? 0),
            ],
            TipoCampo::Selecao => (string) ($campo['padrao'] ?? ($campo['opcoes'][0] ?? '')),
            TipoCampo::Lista => [],
            TipoCampo::Rolagem => null,
        };
    }
}
