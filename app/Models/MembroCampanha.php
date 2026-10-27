<?php

namespace App\Models;

use App\Enums\PapelCampanha;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Table('campanha_usuario')]
class MembroCampanha extends Pivot
{
    public $incrementing = true;

    protected function casts(): array
    {
        return [
            'papel' => PapelCampanha::class,
        ];
    }
}
