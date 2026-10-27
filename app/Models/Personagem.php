<?php

namespace App\Models;

use App\Enums\TipoFicha;
use App\Servicos\Fichas\EstruturaFicha;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Personagem da CONTA do usuário. Não pertence a campanha nenhuma.
 * Importar para uma mesa cria uma Ficha com cópia dos valores; não há vínculo.
 */
#[Table(name: 'personagens')]
class Personagem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'tipo' => TipoFicha::class,
            'valores' => 'array',
            'publico' => 'boolean',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function sistema(): BelongsTo
    {
        return $this->belongsTo(SistemaJogo::class, 'sistema_jogo_id');
    }

    public function ficha(): HasOne
    {
        return $this->hasOne(Ficha::class, 'personagem_id');
    }

    public function estrutura(): EstruturaFicha
    {
        return $this->sistema->estruturaAtual($this->tipo);
    }

    public function valor(string $chave, mixed $padrao = null): mixed
    {
        return data_get($this->valores, $chave, $padrao);
    }

    public function ehNpc(): bool
    {
        return $this->tipo === TipoFicha::Npc;
    }

    /** O que vai para a mesa na importação. */
    public function dadosParaCopia(): array
    {
        return [
            'tipo' => $this->tipo,
            'nome' => $this->nome,
            'retrato_caminho' => $this->retrato_caminho,
            'valores' => $this->valores,
        ];
    }
}
