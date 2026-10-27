<?php

namespace App\Http\Requests\Biblioteca;

use App\Enums\TipoItemBiblioteca;
use App\Models\ItemBiblioteca;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AtualizarItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        $campanha = $this->route('campanha');
        $item = $this->route('item');

        return $item->campanha_id === $campanha->id
            && $this->user()->can('atualizar', $item);
    }

    public function rules(): array
    {
        $campanha = $this->route('campanha');
        $item = $this->route('item');

        return [
            'nome' => ['required', 'string', 'max:120'],
            'pasta_id' => [
                'nullable',
                'integer',
                Rule::exists('itens_biblioteca', 'id')
                    ->where('campanha_id', $campanha->id)
                    ->where('tipo', TipoItemBiblioteca::Pasta->value),
                function (string $atributo, mixed $valor, Closure $falhar) use ($item): void {
                    $destino = ItemBiblioteca::find($valor);

                    if (! $destino) {
                        return;
                    }

                    if (in_array($destino->id, $item->idsDaSubarvore(), true)) {
                        $falhar('Uma pasta não pode ser movida para dentro dela mesma.');

                        return;
                    }

                    // nível em que o item ficaria + os níveis que ele carrega dentro de si
                    $nivelFinal = $destino->nivel() + 1 + $item->alturaDaSubarvore();

                    if ($item->ehPasta() && $nivelFinal > ItemBiblioteca::NIVEL_MAXIMO) {
                        $falhar('Mover para esta pasta passaria do nível máximo de pastas dentro de pastas.');
                    }
                },
            ],
            'visivel_para_jogadores' => ['nullable', 'boolean'],
            'texto' => ['nullable', 'string', 'max:20000'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'Informe o nome.',
            'nome.max' => 'O nome pode ter no máximo 120 caracteres.',
            'pasta_id.exists' => 'A pasta escolhida não existe nesta campanha.',
            'texto.max' => 'O texto pode ter no máximo 20.000 caracteres.',
        ];
    }
}
