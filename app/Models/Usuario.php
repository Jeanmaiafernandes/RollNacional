<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Table(name: 'usuarios')]
class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    const CREATED_AT = 'criado_em';
    const UPDATED_AT = 'atualizado_em';

    protected $authPasswordName = 'senha';

    protected $guarded = [
        'id',
        'eh_admin',
        'plano',
        'email_verified_at',
        'remember_token',
    ];

    protected $hidden = [
        'senha',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'senha' => 'hashed',
            'disponibilidade' => 'array',
            'eh_admin' => 'boolean',
            'mostrar_personagens' => 'boolean',
        ];
    }
}
