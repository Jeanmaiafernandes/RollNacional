<?php

namespace App\Http\Requests\Personagem;

use App\Models\Personagem;
use App\Servicos\Fichas\RegrasDeValidacao;
use Illuminate\Foundation\Http\FormRequest;

/** Edição: sistema e tipo não mudam; as regras vêm da estrutura do personagem. */
class AtualizarPersonagemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('atualizar', $this->personagem());
    }

    public function rules(): array
    {
        return ['nome' => ['required', 'string', 'max:120']]
            + app(RegrasDeValidacao::class)->para($this->personagem()->estrutura());
    }

    public function attributes(): array
    {
        return app(RegrasDeValidacao::class)->atributos($this->personagem()->estrutura());
    }

    public function personagem(): Personagem
    {
        return $this->route('personagem');
    }
}
