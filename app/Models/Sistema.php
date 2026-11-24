<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sistema extends Model
{
    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $table = 'sistemas';

    protected $guarded = ['id'];

    /**
     * Aparência de cada sistema enquanto a tabela não tem colunas para isso.
     * Se um dia a tabela ganhar "sigla", "cor" ou "dado", o valor da coluna passa a valer.
     */
    private const APARENCIA = [
        'tormenta20' => ['sigla' => 'T20', 'cor' => '#8a2a2e', 'dado' => 'd20', 'ficha' => 'Em construção'],
        'dnd-5e' => ['sigla' => '5E', 'cor' => '#244a72', 'dado' => 'd20', 'ficha' => 'Em construção'],
        'etmos' => ['sigla' => 'ETM', 'cor' => '#3e1c43', 'dado' => '2d6', 'ficha' => 'Planejada'],
    ];

    protected function casts(): array
    {
        return [
            'publicado' => 'boolean',
        ];
    }

    public function scopePublicados(Builder $consulta): void
    {
        $consulta->where('publicado', true);
    }

    protected function sigla(): Attribute
    {
        return Attribute::get(fn ($valor) => $valor ?? $this->aparencia('sigla') ?? Str::upper(Str::substr($this->nome, 0, 3)));
    }

    protected function cor(): Attribute
    {
        return Attribute::get(fn ($valor) => $valor ?? $this->aparencia('cor') ?? '#4a3f3a');
    }

    protected function dado(): Attribute
    {
        return Attribute::get(fn ($valor) => $valor ?? $this->aparencia('dado'));
    }

    protected function situacaoFicha(): Attribute
    {
        return Attribute::get(fn () => $this->aparencia('ficha') ?? 'Planejada');
    }

    private function aparencia(string $campo): ?string
    {
        return self::APARENCIA[$this->slug][$campo] ?? null;
    }
}
