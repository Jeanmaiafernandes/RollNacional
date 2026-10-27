<?php

namespace App\Http\Requests\Campanha;

use Illuminate\Foundation\Http\FormRequest;

/** O sistema é fixo desde a criação: não aparece aqui. */
class AtualizarCampanhaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('atualizar', $this->route('campanha'));
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:120'],
            'descricao' => ['nullable', 'string', 'max:5000'],
            'senha' => ['nullable', 'string', 'min:4', 'max:72'],
        ];
    }
}
