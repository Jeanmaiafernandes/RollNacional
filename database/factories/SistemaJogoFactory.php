<?php

namespace Database\Factories;

use App\Enums\StatusSistema;
use App\Enums\StatusVersao;
use App\Models\SistemaJogo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SistemaJogoFactory extends Factory
{
    protected $model = SistemaJogo::class;

    public function definition(): array
    {
        $nome = fake()->unique()->words(2, true);

        return [
            'nome' => Str::title($nome),
            'slug' => Str::slug($nome),
            'status' => StatusSistema::Publicado,
        ];
    }

    /** Cria uma versão 1.0 publicada com estruturas pj e npc simples. */
    public function comVersao(?array $estruturas = null): static
    {
        return $this->afterCreating(function (SistemaJogo $sistema) use ($estruturas) {
            $padrao = ['secoes' => [[
                'chave' => 'base', 'titulo' => 'Base',
                'campos' => [
                    ['chave' => 'agilidade', 'tipo' => 'numero', 'rotulo' => 'Agilidade', 'padrao' => 1, 'minimo' => 0, 'maximo' => 5],
                    ['chave' => 'pv', 'tipo' => 'recurso', 'rotulo' => 'Vida'],
                    ['chave' => 'descricao', 'tipo' => 'texto_longo', 'rotulo' => 'Descrição', 'publico' => true],
                ],
            ]]];

            $sistema->versoes()->create([
                'numero' => '1.0',
                'estruturas' => $estruturas ?? ['pj' => $padrao, 'npc' => $padrao],
                'status' => StatusVersao::Publicada,
                'publicada_em' => now(),
            ]);
        });
    }
}
