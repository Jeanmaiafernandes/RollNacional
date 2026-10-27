<?php

namespace App\Http\Requests\Personagem;

use App\Enums\StatusSistema;
use App\Enums\TipoFicha;
use App\Models\SistemaJogo;
use App\Servicos\Fichas\RegrasDeValidacao;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Criação: sistema e tipo vêm do formulário; as regras dos "valores"
 * são geradas a partir da estrutura daquele sistema/tipo.
 */
class SalvarPersonagemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $regras = [
            'nome' => ['required', 'string', 'max:120'],
            'sistema_jogo_id' => ['required', 'integer',
                Rule::exists('sistemas_jogo', 'id')->where('status', StatusSistema::Publicado->value)],
            'tipo' => ['required', Rule::enum(TipoFicha::class)],
        ];

        $sistema = $this->sistema();

        if ($sistema !== null && $this->tipo() !== null) {
            $regras += app(RegrasDeValidacao::class)->para($sistema->estruturaAtual($this->tipo()));
        }

        return $regras;
    }

    public function attributes(): array
    {
        $nomes = ['sistema_jogo_id' => 'sistema'];
        $sistema = $this->sistema();

        if ($sistema !== null && $this->tipo() !== null) {
            $nomes += app(RegrasDeValidacao::class)->atributos($sistema->estruturaAtual($this->tipo()));
        }

        return $nomes;
    }

    public function sistema(): ?SistemaJogo
    {
        return SistemaJogo::query()->publicados()->find($this->input('sistema_jogo_id'));
    }

    public function tipo(): ?TipoFicha
    {
        return TipoFicha::tryFrom((string) $this->input('tipo'));
    }
}
