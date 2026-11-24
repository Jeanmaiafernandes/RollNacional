<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Validator;

/**
 * Cria (ou promove) a conta de administrador.
 * Pergunta os dados no terminal, então nenhuma senha fica no código nem no .env.
 *
 *   php artisan db:seed --class=AdminSeeder
 */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = $this->command->ask('E-mail do administrador');

        $usuario = Usuario::where('email', $email)->first();

        if ($usuario) {
            $usuario->forceFill(['eh_admin' => true])->save();
            $this->command->info("{$usuario->nome} agora é administrador.");

            return;
        }

        $dados = [
            'nome' => $this->command->ask('Nome de exibição'),
            'nome_usuario' => $this->command->ask('Nome de usuário (minúsculas, números e traço)'),
            'email' => $email,
            'senha' => $this->command->secret('Senha (mínimo 8 caracteres)'),
        ];

        $validacao = Validator::make($dados, [
            'nome' => ['required', 'string', 'max:100'],
            'nome_usuario' => ['required', 'regex:/^[a-z0-9-]+$/', 'max:30', 'unique:usuarios,nome_usuario'],
            'email' => ['required', 'email', 'unique:usuarios,email'],
            'senha' => ['required', 'string', 'min:8'],
        ]);

        if ($validacao->fails()) {
            foreach ($validacao->errors()->all() as $erro) {
                $this->command->error($erro);
            }

            return;
        }

        // eh_admin está no $guarded do model, por isso o forceCreate.
        Usuario::query()->forceCreate([...$dados, 'eh_admin' => true]);

        $this->command->info("Administrador {$dados['nome']} criado.");
    }
}
