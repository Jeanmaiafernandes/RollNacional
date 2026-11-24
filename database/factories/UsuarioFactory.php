<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Usuario>
 */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    /** Senha de todas as contas geradas. */
    public const SENHA = 'senha1234';

    /** Hash calculado uma vez só: gerar um por conta deixa o seeder lento. */
    private static ?string $senhaHash = null;

    private const BIOS = [
        'Mestre de Tormenta às sextas, jogador de D&D aos domingos.',
        'Coleciono dados que nunca rolam acima de 5.',
        'Narro campanhas curtas de terror e investigação.',
        'Primeira mesa foi em 2019 e nunca mais parei.',
        'Gosto de personagens de suporte e de ler o livro inteiro antes de jogar.',
        'Procurando grupo para campanha online à noite.',
        'Fã de sistemas nacionais e de qualquer coisa com magia de palavras.',
    ];

    public function definition(): array
    {
        $faker = fake('pt_BR');
        $nome = $faker->firstName().' '.$faker->lastName();
        $usuario = Str::of($nome)->before(' ')->slug()->limit(20, '')
            .'-'.$faker->unique()->numberBetween(10, 99999);

        return [
            'nome' => $nome,
            'nome_usuario' => $usuario,
            'email' => $usuario.'@exemplo.test',
            'senha' => static::$senhaHash ??= Hash::make(self::SENHA),
            'bio' => $faker->optional(0.7)->randomElement(self::BIOS),
            'caminho_avatar' => null,
            'mostrar_personagens' => $faker->boolean(80),
            'eh_admin' => false,
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => ['eh_admin' => true]);
    }

    public function semBio(): static
    {
        return $this->state(fn () => ['bio' => null]);
    }

    public function personagensOcultos(): static
    {
        return $this->state(fn () => ['mostrar_personagens' => false]);
    }
}
