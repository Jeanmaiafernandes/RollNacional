<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('fichas')]
class Ficha extends Model
{
    protected $guarded = ['id'];

    protected function itemBiblioteca(): BelongsTo
    {
        return $this->belongsTo(ItemBiblioteca::class, 'item_biblioteca_id');
    }

    public function sistemaJogo(): BelongsTo
    {
        return $this->belongsTo(SistemaJogo::class, 'sistema_jogo_id');
    }
}
