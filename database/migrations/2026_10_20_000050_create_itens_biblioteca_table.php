<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Nível CAMPANHA: tudo que aparece na árvore da biblioteca é uma linha aqui.
// Pasta, anotação e cena guardam o conteúdo em JSON; ficha tem tabela própria.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('itens_biblioteca', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campanha_id')->constrained('campanhas')->cascadeOnDelete();
            $table->foreignId('pasta_id')->nullable()->constrained('itens_biblioteca')->cascadeOnDelete();
            $table->foreignId('dono_id')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->string('tipo', 20);                               // TipoItemBiblioteca
            $table->string('nome');
            $table->unsignedInteger('ordem')->default(0);
            $table->string('visibilidade', 20)->default('oculto');    // Visibilidade
            $table->boolean('fixo')->default(false);                  // pasta "Personagens dos jogadores"
            $table->json('conteudo')->nullable();
            $table->timestamps();

            $table->index(['campanha_id', 'pasta_id', 'ordem']);
        });

        // Modo "específico": quem, além de mestre/co-mestre, vê o item.
        Schema::create('item_biblioteca_usuario', function (Blueprint $table) {
            $table->foreignId('item_biblioteca_id')->constrained('itens_biblioteca')->cascadeOnDelete();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();

            $table->primary(['item_biblioteca_id', 'usuario_id']);
        });

        Schema::table('campanhas', function (Blueprint $table) {
            $table->foreignId('cena_ativa_id')->nullable()->after('espectador_pode_escrever')
                ->constrained('itens_biblioteca')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('campanhas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cena_ativa_id');
        });
        Schema::dropIfExists('item_biblioteca_usuario');
        Schema::dropIfExists('itens_biblioteca');
    }
};
