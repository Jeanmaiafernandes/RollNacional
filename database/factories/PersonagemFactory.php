<?php

namespace Database\Factories;

use App\Enums\TipoFicha;
use App\Models\Personagem;
use App\Models\SistemaJogo;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonagemFactory extends Factory
{
    protected $model = Personagem::class;

    public function definition(): array
    {
        return [
            'usuario_id' => Usuario::factory(),
            'sistema_jogo_id' => SistemaJogo::factory()->comVersao(),
            'tipo' => TipoFicha::Pj,
            'nome' => fake()->firstName(),
            'valores' => ['agilidade' => 2, 'pv' => ['atual' => 10, 'maximo' => 12], 'descricao' => ''],
        ];
    }

    public function npc(): static
    {
        return $this->state(fn () => ['tipo' => TipoFicha::Npc]);
    }
}
