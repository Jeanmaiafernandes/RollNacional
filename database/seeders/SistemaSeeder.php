<?php

namespace Database\Seeders;

use App\Models\Sistema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SistemaSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->sistemas() as $dados) {
            $dados['caminho_capa'] = $this->copiarCapa($dados['caminho_capa']);

            // Procura pelo slug: rodar de novo só atualiza, não duplica.
            Sistema::updateOrCreate(['slug' => $dados['slug']], $dados);
        }
    }

    /**
     * As capas ficam em database/seeders/capas e vão para o disco "public",
     * no mesmo lugar onde o painel de admin vai salvar os uploads depois.
     */
    private function copiarCapa(?string $arquivo): ?string
    {
        if (! $arquivo) {
            return null;
        }

        $origem = database_path('seeders/capas/'.$arquivo);

        if (! File::exists($origem)) {
            $this->command?->warn("Capa não encontrada: {$origem}");

            return null;
        }

        $destino = 'sistemas/'.$arquivo;
        Storage::disk('public')->put($destino, File::get($origem));

        return $destino;
    }

    private function sistemas(): array
    {
        return [
            [
                'nome' => 'Tormenta20',
                'slug' => 'tormenta20',
                'resumo' => 'O maior RPG brasileiro, ambientado em Arton. Atributos, perícias, poderes e magias crescem a cada nível, e a ficha acompanha tudo.',
                'descricao' => implode("\n\n", [
                    'Tormenta20 é o RPG de fantasia mais jogado do Brasil. Os heróis enfrentam a Tormenta, uma tempestade rubra que corrompe tudo o que toca, num mundo cheio de deuses, reinos e masmorras.',
                    'As rolagens usam um d20 somado a atributos e perícias. Cada classe ganha poderes a cada nível, e boa parte do jogo está em montar a combinação certa.',
                ]),
                'editora' => 'Jambô Editora',
                'licenca' => null,
                'origem' => 'nacional',
                'caminho_capa' => 'capa-tormenta20.webp',
                'publicado' => true,
            ],
            [
                'nome' => 'D&D 5e',
                'slug' => 'dnd-5e',
                'resumo' => 'O clássico de fantasia com masmorras e dragões. Ficha com proficiências, salvaguardas e espaços de magia calculados.',
                'descricao' => implode("\n\n", [
                    'Dungeons & Dragons é o RPG de fantasia mais conhecido do mundo. Um grupo de aventureiros explora masmorras, enfrenta dragões e cresce em nível a cada aventura.',
                    'As rolagens usam um d20 somado ao modificador do atributo e, quando o personagem é proficiente, ao bônus de proficiência. Vantagem e desvantagem trocam os modificadores por uma segunda rolagem.',
                ]),
                'editora' => 'Wizards of the Coast',
                'licenca' => 'SRD 5.1 (CC BY 4.0)',
                'origem' => 'estrangeiro',
                'caminho_capa' => 'capa-dnd5e.webp',
                'publicado' => true,
            ],
            [
                'nome' => 'Etmos',
                'slug' => 'etmos',
                'resumo' => 'Um RPG sobre palavras que mudam o mundo. Oradores de Brasilis conjuram magia montando frases com as Partículas do Grimório.',
                'descricao' => implode("\n\n", [
                    'Etmos é um RPG sobre palavras que mudam o mundo. Os Oradores estudam em Brasilis, uma escola de magia, e conjuram montando frases com as Partículas do Grimório.',
                    'Existem dois mundos: o Mundano, da rua, da escola e do boleto, e o Fantástico, moldado pela linguagem e escondido atrás dos Portais do Meio.',
                    'As rolagens usam 2d6 somados a Corpo, Mente ou Alma. Quanto mais Partículas numa frase, mais complexa a magia e maior o Estresse.',
                ]),
                'editora' => 'Editora Balde Galáctico',
                'licenca' => null,
                'origem' => 'independente',
                'caminho_capa' => 'capa-etmos.webp',
                'publicado' => true,
            ],
        ];
    }
}
