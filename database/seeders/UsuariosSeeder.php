<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Usuario::query()->firstOrNew(['email' => 'admin@mesa.localhost']);
        $admin->nome = 'Administrador';
        $admin->senha = 'admin12345';   // o cast "hashed" gera o hash
        $admin->administrador = true;
        $admin->email_verified_at = now();
        $admin->save();

        $mestre = Usuario::query()->firstOrNew(['email' => 'mestre@mesa.localhost']);
        $mestre->nome = 'Mestre Teste';
        $mestre->senha = 'senha12345';
        $mestre->administrador = false;
        $mestre->email_verified_at = now();
        $mestre->save();
    }
}
