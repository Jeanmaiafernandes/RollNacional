<?php

namespace App\Http\Requests\Biblioteca;

use App\Enums\TipoItemBiblioteca;
use App\Models\ItemBiblioteca;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SalvarItemRequest extends FormRequest
{
    /**
     * Os erros deste formulário vão para uma "sacola" própria, porque ele divide a tela
     * com o formulário de edição do item aberto, que tem campos com os mesmos nomes.
     * Na view: @error('nome', 'novoItem')
     */
    protected $errorBag = 'novoItem';

    public function authorize(): bool
    {
        return $this->user()->can('criar', [ItemBiblioteca::class, $this->route('campanha')]);
    }

    public function rules(): array
    {
        $campanha = $this->route('campanha');

        return [
            'tipo' => ['required', Rule::enum(TipoItemBiblioteca::class)],
            'nome' => ['required', 'string', 'max:120'],
            'pasta_id' => [
                'nullable',
                'integer',
                // a pasta escolhida precisa existir, ser desta campanha e ser mesmo uma pasta
                Rule::exists('itens_biblioteca', 'id')
                    ->where('campanha_id', $campanha->id)
                    ->where('tipo', TipoItemBiblioteca::Pasta->value),
                function (string $atributo, mixed $valor, Closure $falhar): void {
                    // o limite de níveis vale para pastas; anotações cabem em qualquer pasta
                    if ($this->input('tipo') !== TipoItemBiblioteca::Pasta->value) {
                        return;
                    }

                    $pasta = ItemBiblioteca::find($valor);

                    if ($pasta && $pasta->nivel() >= ItemBiblioteca::NIVEL_MAXIMO) {
                        $falhar('Esta pasta já está no nível máximo de pastas dentro de pastas.');
                    }
                },
            ],
            'visivel_para_jogadores' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'tipo.required' => 'Escolha o tipo do item.',
            'tipo.enum' => 'Tipo de item inválido.',
            'nome.required' => 'Informe o nome.',
            'nome.max' => 'O nome pode ter no máximo 120 caracteres.',
            'pasta_id.exists' => 'A pasta escolhida não existe nesta campanha.',
        ];
    }
}
