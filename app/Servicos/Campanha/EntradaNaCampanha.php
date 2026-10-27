<?php

namespace App\Servicos\Campanha;

use App\Enums\PapelCampanha;
use App\Models\Campanha;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/** Código + senha → entra como Espectador. Quem já participa só é redirecionado. */
class EntradaNaCampanha
{
    public function entrar(string $codigo, string $senha, Usuario $usuario): Campanha
    {
        $campanha = Campanha::query()
            ->where('codigo_convite', Str::upper(trim($codigo)))
            ->first();

        // Mensagem única: não revelar se o código existe.
        if ($campanha === null || ! Hash::check($senha, $campanha->senha)) {
            throw ValidationException::withMessages([
                'codigo_convite' => 'Código ou senha incorretos.',
            ]);
        }

        if (! $campanha->participa($usuario)) {
            $campanha->membros()->attach($usuario->id, [
                'papel' => PapelCampanha::Espectador->value,
                'pode_criar_itens' => false,
            ]);
        }

        return $campanha;
    }
}
