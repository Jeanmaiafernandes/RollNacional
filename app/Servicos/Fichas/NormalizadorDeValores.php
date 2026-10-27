<?php

namespace App\Servicos\Fichas;

use App\Enums\TipoCampo;
use Illuminate\Support\Str;

/**
 * Junta a entrada validada com os valores atuais, aplicando casts.
 * Campo ausente na entrada mantém o valor atual (ou o padrão).
 * Listas: cada item tem id; item com _remover marcado sai; item sem nenhum subcampo preenchido é ignorado.
 */
class NormalizadorDeValores
{
    public function __construct(private readonly MontadorDeFicha $montador)
    {
    }

    public function normalizar(EstruturaFicha $estrutura, array $atuais, array $entrada): array
    {
        $resultado = [];

        foreach ($estrutura->camposComEntrada() as $campo) {
            $chave = $campo['chave'];
            $tipo = $estrutura->tipoDe($campo);
            $atual = $atuais[$chave] ?? $this->montador->padraoDoCampo($tipo, $campo);

            if (! array_key_exists($chave, $entrada)) {
                $resultado[$chave] = $atual;
                continue;
            }

            $resultado[$chave] = match ($tipo) {
                TipoCampo::Texto, TipoCampo::TextoLongo => trim((string) ($entrada[$chave] ?? '')),
                TipoCampo::Numero => (int) ($entrada[$chave] ?? 0),
                TipoCampo::Selecao => (string) ($entrada[$chave] ?? ''),
                TipoCampo::Recurso => $this->recurso($entrada[$chave], $atual),
                TipoCampo::Lista => $this->lista($entrada[$chave] ?? [], $campo),
                TipoCampo::Rolagem => null,
            };
        }

        return $resultado;
    }

    private function recurso(mixed $entrada, array $atual): array
    {
        $entrada = is_array($entrada) ? $entrada : [];

        $maximo = isset($entrada['maximo']) ? (int) $entrada['maximo'] : (int) ($atual['maximo'] ?? 0);
        $valorAtual = isset($entrada['atual']) ? (int) $entrada['atual'] : (int) ($atual['atual'] ?? 0);

        return ['atual' => $valorAtual, 'maximo' => max(0, $maximo)];
    }

    private function lista(mixed $itens, array $campo): array
    {
        if (! is_array($itens)) {
            return [];
        }

        $subcampos = $campo['subcampos'] ?? [];
        $saida = [];

        foreach ($itens as $item) {
            if (! is_array($item) || ! empty($item['_remover'])) {
                continue;
            }

            $linha = ['id' => $item['id'] ?? (string) Str::uuid()];
            $temConteudo = false;

            foreach ($subcampos as $sub) {
                $tipoSub = TipoCampo::tryFrom($sub['tipo'] ?? '') ?? TipoCampo::Texto;
                $valor = $item[$sub['chave']] ?? null;

                $linha[$sub['chave']] = match ($tipoSub) {
                    TipoCampo::Numero => $valor === null || $valor === '' ? 0 : (int) $valor,
                    default => trim((string) ($valor ?? '')),
                };

                if ($linha[$sub['chave']] !== '' && $linha[$sub['chave']] !== 0) {
                    $temConteudo = true;
                }
            }

            if ($temConteudo) {
                $saida[] = $linha;
            }
        }

        return array_values($saida);
    }
}
