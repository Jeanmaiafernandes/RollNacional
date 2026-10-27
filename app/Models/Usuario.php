<?php

namespace App\Models;

use Database\Factories\UsuarioFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $guarded = [];

    protected $hidden = ['senha', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'senha' => 'hashed',
            'administrador' => 'boolean',
        ];
    }

    public function getAuthPasswordName(): string
    {
        return 'senha';
    }

    protected static function newFactory()
    {
        return UsuarioFactory::new();
    }

    // ---- Relações ----

    public function personagens(): HasMany
    {
        return $this->hasMany(Personagem::class, 'usuario_id');
    }

    public function campanhasMestradas(): HasMany
    {
        return $this->hasMany(Campanha::class, 'mestre_id');
    }

    public function campanhas(): BelongsToMany
    {
        return $this->belongsToMany(Campanha::class, 'campanha_usuario', 'usuario_id', 'campanha_id')
            ->using(MembroCampanha::class)
            ->withPivot(['papel', 'pode_criar_itens'])
            ->withTimestamps();
    }
}
