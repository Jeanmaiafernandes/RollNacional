<?php

namespace App\Models;

use App\Enums\TipoItemBiblioteca;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Um item da biblioteca da mesa: uma pasta ou algo guardado numa pasta.
 * A árvore é formada pela coluna pasta_id, que aponta para outro item da mesma tabela.
 */
#[Table(name: 'itens_biblioteca')]
class ItemBiblioteca extends Model
{
    /** Quantos níveis de pasta dentro de pasta são permitidos. */
    public const NIVEL_MAXIMO = 5;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'campanha_id' => 'integer',
            'pasta_id' => 'integer',
            'tipo' => TipoItemBiblioteca::class,
            'visivel_para_jogadores' => 'boolean',
            'conteudo' => 'array',
        ];
    }

    public function campanha(): BelongsTo
    {
        return $this->belongsTo(Campanha::class, 'campanha_id');
    }

    /** A pasta onde este item está (nulo quando está na raiz). */
    public function pasta(): BelongsTo
    {
        return $this->belongsTo(self::class, 'pasta_id');
    }

    /** O que está diretamente dentro deste item (só pastas têm filhos). */
    public function filhos(): HasMany
    {
        return $this->hasMany(self::class, 'pasta_id');
    }

    public function dono(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'dono_id');
    }

    public function ehPasta(): bool
    {
        return $this->tipo === TipoItemBiblioteca::Pasta;
    }

    /** Texto de uma anotação. */
    public function texto(): string
    {
        return $this->conteudo['texto'] ?? '';
    }

    /**
     * Um jogador só vê o item se ele e todas as pastas acima dele estiverem visíveis.
     */
    public function visivelParaJogadores(): bool
    {
        for ($no = $this; $no !== null; $no = $no->pasta) {
            if (! $no->visivel_para_jogadores) {
                return false;
            }
        }

        return true;
    }

    /** Em que nível o item está: 1 = raiz, 2 = dentro de uma pasta da raiz, e assim por diante. */
    public function nivel(): int
    {
        $nivel = 1;

        for ($no = $this->pasta; $no !== null; $no = $no->pasta) {
            $nivel++;
        }

        return $nivel;
    }

    public function idsDaSubarvore(): array
    {
        $ids = [$this->id];
        $nivelAtual = [$this->id];

        while ($nivelAtual !== []) {
            $nivelAtual = static::whereIn('pasta_id', $nivelAtual)->pluck('id')->all();
            $ids = array_merge($ids, $nivelAtual);
        }

        return $ids;
    }

    /** Quantos níveis existem abaixo deste item (0 = nada dentro dele). */
    public function alturaDaSubarvore(): int
    {
        $altura = 0;
        $nivelAtual = [$this->id];

        while (true) {
            $nivelAtual = static::whereIn('pasta_id', $nivelAtual)->pluck('id')->all();

            if ($nivelAtual === []) {
                return $altura;
            }

            $altura++;
        }
    }
}
