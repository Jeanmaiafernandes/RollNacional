<?php

namespace App\Enums;

/**
 * Tipos de campo aceitos na estrutura de ficha (JSON da versão do sistema).
 * "rolagem" não guarda valor: é um botão com expressão.
 */
enum TipoCampo: string
{
    case Texto = 'texto';
    case TextoLongo = 'texto_longo';
    case Numero = 'numero';
    case Recurso = 'recurso';     // { atual, maximo }
    case Selecao = 'selecao';     // opcoes: [...]
    case Lista = 'lista';         // subcampos: [...] (texto, numero, selecao)
    case Rolagem = 'rolagem';     // expressao: "@{agilidade}d20kh1"

    public function guardaValor(): bool
    {
        return $this !== self::Rolagem;
    }

    public function podeSerSubcampo(): bool
    {
        return in_array($this, [self::Texto, self::Numero, self::Selecao], true);
    }
}
