<?php

namespace App\Http\Requests\Campanha;

use Illuminate\Foundation\Http\FormRequest;

class EntrarNaCampanhaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo_convite' => ['required', 'string', 'size:8'],
            'senha' => ['required', 'string'],
        ];
    }

    public function attributes(): array
    {
        return ['codigo_convite' => 'código de convite'];
    }
}
