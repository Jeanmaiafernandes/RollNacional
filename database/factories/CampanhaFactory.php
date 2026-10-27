<?php

namespace Database\Factories;

use App\Models\Campanha;
use App\Models\SistemaJogo;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampanhaFactory extends Factory
{
    protected $model = Campanha::class;

    public function definition(): array
    {
        return [
            'mestre_id' => Usuario::factory(),
            'sistema_jogo_id' => SistemaJogo::factory()->comVersao(),
            'nome' => fake()->sentence(3),
            'descricao' => fake()->paragraph(),
            'senha' => 'mesa123',
        ];
    }
}
