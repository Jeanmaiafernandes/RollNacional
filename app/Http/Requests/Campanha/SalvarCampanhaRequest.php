<?php

namespace App\Http\Requests\Campanha;

use App\Enums\StatusSistema;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SalvarCampanhaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:120'],
            'descricao' => ['nullable', 'string', 'max:5000'],
            'sistema_jogo_id' => ['required', 'integer',
                Rule::exists('sistemas_jogo', 'id')->where('status', StatusSistema::Publicado->value)],
            'senha' => ['required', 'string', 'min:4', 'max:72'],
        ];
    }

    public function attributes(): array
    {
        return ['sistema_jogo_id' => 'sistema', 'nome' => 'nome', 'senha' => 'senha'];
    }
}
