<?php

namespace App\Http\Requests\Autenticacao;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CadastroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:usuarios,email'],
            'senha' => ['required', 'string', Password::min(8)->max(255), 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required'   => 'Informe o nome.',
            'email.required'  => 'Informe o e-mail.',
            'email.email'     => 'Informe um e-mail válido.',
            'email.unique'    => 'Este e-mail já está cadastrado.',
            'senha.required'  => 'Informe a senha.',
            'senha.min'       => 'A senha precisa ter pelo menos 8 caracteres.',
            'senha.confirmed' => 'A confirmação de senha não confere.',
        ];
    }
}
