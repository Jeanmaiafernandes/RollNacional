<?php

namespace App\Models;

use App\Enums\StatusSistema;
use App\Enums\StatusVersao;
use App\Enums\TipoFicha;
use App\Servicos\Fichas\EstruturaFicha;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table(name: 'sistemas_jogo')]
class SistemaJogo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'status' => StatusSistema::class,
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ---- Relações ----

    public function versoes(): HasMany
    {
        return $this->hasMany(VersaoSistema::class, 'sistema_jogo_id');
    }

    public function campanhas(): HasMany
    {
        return $this->hasMany(Campanha::class, 'sistema_jogo_id');
    }

    public function personagens(): HasMany
    {
        return $this->hasMany(Personagem::class, 'sistema_jogo_id');
    }

    public function fichas(): HasMany
    {
        return $this->hasMany(Ficha::class, 'sistema_jogo_id');
    }

    // ---- Escopos ----

    public function scopePublicados(Builder $consulta): Builder
    {
        return $consulta->where('status', StatusSistema::Publicado);
    }

    // ---- Versão e estrutura ----

    public function versaoAtual(): ?VersaoSistema
    {
        return $this->versoes()
            ->where('status', StatusVersao::Publicada)
            ->orderByDesc('publicada_em')
            ->first();
    }

    /** Estrutura do tipo pedido (pj ou npc), já embrulhada no objeto de valor. */
    public function estruturaAtual(TipoFicha $tipo): EstruturaFicha
    {
        return EstruturaFicha::deArray($this->versaoAtual()?->estrutura($tipo) ?? []);
    }

    public function estaPublicado(): bool
    {
        return $this->status === StatusSistema::Publicado;
    }
}
