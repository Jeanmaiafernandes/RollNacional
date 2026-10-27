<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AtualizarSenhaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'senha_atual' => ['required', 'string', 'current_password'],
            'senha'       => ['required', 'string', Password::min(8)->max(255), 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'senha_atual.required'         => 'Informe a senha atual.',
            'senha_atual.current_password' => 'A senha atual não confere.',
            'senha.required'               => 'Informe a nova senha.',
            'senha.min'                    => 'A senha precisa ter pelo menos 8 caracteres.',
            'senha.confirmed'              => 'A confirmação de senha não confere.',
        ];
    }
}
