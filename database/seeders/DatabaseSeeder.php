<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SistemaSeeder::class,
        ]);

        if (app()->environment('local')) {
            $this->call(UsuariosSeeder::class);
        }

        // A conta de admin é criada à parte, porque o seeder pergunta os dados:
        // php artisan db:seed --class=AdminSeeder
    }
}
