<?php

namespace App\Models;

use App\Enums\StatusVersao;
use App\Enums\TipoFicha;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table(name: 'versoes_sistema')]
class VersaoSistema extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'estruturas' => 'array',
            'configuracao' => 'array',
            'status' => StatusVersao::class,
            'publicada_em' => 'datetime',
        ];
    }

    public function sistema(): BelongsTo
    {
        return $this->belongsTo(SistemaJogo::class, 'sistema_jogo_id');
    }

    public function baseadaEm(): BelongsTo
    {
        return $this->belongsTo(VersaoSistema::class, 'baseado_em_id');
    }

    /** Estrutura de um tipo de ficha; sem o tipo cadastrado, devolve vazia. */
    public function estrutura(TipoFicha $tipo): array
    {
        return $this->estruturas[$tipo->value] ?? ['secoes' => []];
    }

    public function estaPublicada(): bool
    {
        return $this->status === StatusVersao::Publicada;
    }

    /** Versão publicada é imutável: mudança = nova versão. */
    public function publicar(): void
    {
        $this->status = StatusVersao::Publicada;
        $this->publicada_em = now();
        $this->save();
    }
}
