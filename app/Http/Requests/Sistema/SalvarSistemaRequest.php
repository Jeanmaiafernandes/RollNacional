<?php

namespace App\Http\Requests\Sistema;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SalvarSistemaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'       => ['required', 'string', 'min:3', 'max:100'],
            'slug'       => ['required', 'string', 'min:3', 'max:100', 'unique'],
            'resumo'     => ['nullable', 'string', 'min:3', 'max:100'],
            'descricao'  => ['nullable', 'string', 'min:3', 'max:100'],
            'editora'    => ['nullable', 'string', 'min:3', 'max:100'],
            'licensa'    => ['nullable', 'string', 'min:3', 'max:100'],
            'origem'     => ['required', 'string', 'min:3', 'max:100', 'default' => 'nacional'],
            'caminho_capa' => ['nullable', 'string'],
            'publicado'  => ['nullable', 'boolean', 'default' => false],
            'criado_em'  => ['nullable', 'date', 'date_format:Y-m-d'],
            'atualizado_em'  => ['nullable', 'date', 'date_format:Y-m-d'],
        ];
    }
}
