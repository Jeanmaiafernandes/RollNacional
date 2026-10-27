<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SistemaJogoSeeder::class);

        if (app()->environment('local')) {
            Usuario::query()->firstOrCreate(
                ['email' => 'admin@mesa.localhost'],
                ['nome' => 'Admin', 'senha' => 'senha123', 'administrador' => true],
            );
        }
    }
}
