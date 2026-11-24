<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Database\Factories\UsuarioFactory;
use Illuminate\Database\Seeder;

/**
 * Contas de exemplo para desenvolvimento. Não roda em produção.
 * Todas usam a senha de UsuarioFactory::SENHA.
 */
class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->isProduction()) {
            $this->command?->warn('UsuarioSeeder ignorado: não cria contas de exemplo em produção.');

            return;
        }

        // Conta fixa para entrar no site durante o desenvolvimento
        Usuario::factory()->create([
            'nome' => 'Jogadora Teste',
            'nome_usuario' => 'jogadora',
            'email' => 'jogadora@exemplo.test',
            'bio' => 'Conta de teste da RollNacional.',
            'mostrar_personagens' => true,
        ]);

        Usuario::factory()->count(8)->create();
        Usuario::factory()->semBio()->count(2)->create();
        Usuario::factory()->personagensOcultos()->count(2)->create();

        $this->command?->info('Contas de exemplo criadas. Senha de todas: '.UsuarioFactory::SENHA);
    }
}
