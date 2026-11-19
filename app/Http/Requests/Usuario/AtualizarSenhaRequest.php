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
            // "confirmed" procura o campo senha_confirmation
            'senha' => ['required', 'string', 'confirmed', 'different:senha_atual', Password::defaults()],
        ];
    }

    public function attributes(): array
    {
        return [
            'senha_atual' => 'senha atual',
            'senha' => 'nova senha',
        ];
    }

    public function messages(): array
    {
        return [
            'senha_atual.current_password' => 'A senha atual não confere.',
            'senha.confirmed' => 'As senhas não conferem.',
            'senha.different' => 'A nova senha precisa ser diferente da atual.',
        ];
    }
}
