<?php

namespace App\Models;

use App\Enums\PapelCampanha;
use App\Enums\TipoItemBiblioteca;
use App\Enums\Visibilidade;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Table(name: 'campanhas')]
class Campanha extends Model
{
    use HasFactory;

    public const string NOME_PASTA_PERSONAGENS = 'Personagens dos jogadores';

    protected $guarded = ['id'];

    protected $hidden = ['senha'];

    protected function casts(): array
    {
        return [
            'senha' => 'hashed',
            'espectador_pode_escrever' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        // toda campanha nova ganha um código de convite
        static::creating(function (Campanha $campanha) {
            $campanha->codigo_convite ??= static::gerarCodigoConvite();
        });

        // o mestre entra na pivot e a pasta fixa nasce junto
        static::created(function (Campanha $campanha) {
            $campanha->membros()->attach($campanha->mestre_id, [
                'papel' => PapelCampanha::Mestre->value,
                'pode_criar_itens' => true,
            ]);

            $pasta = new ItemBiblioteca();
            $pasta->campanha_id = $campanha->id;
            $pasta->tipo = TipoItemBiblioteca::Pasta;
            $pasta->nome = self::NOME_PASTA_PERSONAGENS;
            $pasta->visibilidade = Visibilidade::Todos;
            $pasta->fixo = true;
            $pasta->ordem = 0;
            $pasta->save();
        });
    }

    public static function gerarCodigoConvite(): string
    {
        do {
            $codigo = Str::upper(Str::random(8));
        } while (static::where('codigo_convite', $codigo)->exists());

        return $codigo;
    }

    // ---- Relações ----

    public function mestre(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'mestre_id');
    }

    public function sistema(): BelongsTo
    {
        return $this->belongsTo(SistemaJogo::class, 'sistema_jogo_id');
    }

    public function membros(): BelongsToMany
    {
        return $this->belongsToMany(Usuario::class, 'campanha_usuario')
            ->using(MembroCampanha::class)
            ->withPivot(['papel', 'pode_criar_itens'])
            ->withTimestamps();
    }

    public function itens(): HasMany
    {
        return $this->hasMany(ItemBiblioteca::class, 'campanha_id');
    }

    public function cenaAtiva(): BelongsTo
    {
        return $this->belongsTo(ItemBiblioteca::class, 'cena_ativa_id');
    }

    public function mensagens(): HasMany
    {
        return $this->hasMany(Mensagem::class, 'campanha_id');
    }

    public function rolagens(): HasMany
    {
        return $this->hasMany(Rolagem::class, 'campanha_id');
    }

    // ---- Papéis ----

    public function papelDe(Usuario $usuario): ?PapelCampanha
    {
        return $this->membros()->where('usuarios.id', $usuario->id)->first()?->pivot->papel;
    }

    public function participa(Usuario $usuario): bool
    {
        return $this->papelDe($usuario) !== null;
    }

    /** Mestre é o criador: coluna mestre_id, não a pivot. */
    public function ehMestre(Usuario $usuario): bool
    {
        return $this->mestre_id === $usuario->id;
    }

    public function ehMestreOuCoMestre(Usuario $usuario): bool
    {
        return $this->papelDe($usuario)?->ehMestreOuCoMestre() ?? false;
    }

    public function podeCriarItens(Usuario $usuario): bool
    {
        $membro = $this->membros()->where('usuarios.id', $usuario->id)->first();

        return (bool) ($membro?->pivot->pode_criar_itens ?? false);
    }

    // ---- Biblioteca ----

    public function pastaPersonagensDosJogadores(): \stdClass
    {
        return $this->itens()
            ->where('tipo', TipoItemBiblioteca::Pasta)
            ->where('fixo', true)
            ->firstOrFail();
    }
}
