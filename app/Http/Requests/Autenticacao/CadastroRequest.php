<?php

namespace App\Http\Requests\Autenticacao;

use App\Models\Usuario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CadastroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nome_usuario' => Str::lower(trim((string) $this->input('nome_usuario'))),
            'email' => Str::lower(trim((string) $this->input('email'))),
        ]);
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:100'],
            'nome_usuario' => ['required', 'string', 'min:3', 'max:30', 'regex:/^[a-z0-9-]+$/', Rule::unique(Usuario::class, 'nome_usuario')],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(Usuario::class, 'email')],
            // "confirmed" procura o campo senha_confirmation
            'senha' => ['required', 'string', 'confirmed', Password::defaults()],
        ];
    }

    public function attributes(): array
    {
        return [
            'nome_usuario' => 'nome de usuário',
            'senha' => 'senha',
        ];
    }

    public function messages(): array
    {
        return [
            'nome_usuario.regex' => 'Use só letras minúsculas, números e traço.',
            'senha.confirmed' => 'As senhas não conferem.',
        ];
    }
}
