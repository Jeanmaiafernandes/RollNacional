<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AtualizarPerfilPublicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nome_usuario' => Str::lower(trim((string) $this->input('nome_usuario'))),
        ]);
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:100'],
            'nome_usuario' => [
                'required', 'string', 'min:3', 'max:30', 'regex:/^[a-z0-9-]+$/',
                Rule::unique($this->user()->getTable())->ignore($this->user()),
            ],
            'bio' => ['nullable', 'string', 'max:280'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remover_avatar' => ['nullable', 'boolean'],
            'mostrar_personagens' => ['boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nome_usuario' => 'nome de usuário',
            'bio' => 'apresentação',
            'avatar' => 'foto',
        ];
    }

    public function messages(): array
    {
        return [
            'nome_usuario.regex' => 'Use só letras minúsculas, números e traço.',
        ];
    }
}
