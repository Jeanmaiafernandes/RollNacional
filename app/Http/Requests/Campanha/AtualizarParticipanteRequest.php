<?php

namespace App\Http\Requests\Campanha;

use App\Enums\PapelCampanha;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AtualizarParticipanteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('gerirParticipantes', $this->route('campanha'));
    }

    public function rules(): array
    {
        return [
            'papel' => ['required', Rule::in(PapelCampanha::valoresAtribuiveis())],
            'pode_criar_itens' => ['nullable', 'boolean'],
        ];
    }

    public function papel(): PapelCampanha
    {
        return PapelCampanha::from($this->validated('papel'));
    }

    public function podeCriarItens(): bool
    {
        return (bool) $this->validated('pode_criar_itens', false);
    }
}
