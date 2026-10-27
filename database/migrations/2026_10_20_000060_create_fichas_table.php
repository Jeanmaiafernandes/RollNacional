<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fichas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_biblioteca_id')->unique()->constrained('itens_biblioteca')->cascadeOnDelete();
            $table->foreignId('sistema_jogo_id')->constrained('sistemas_jogo')->restrictOnDelete();
            $table->string('tipo', 10);                     // TipoFicha: pj | npc
            $table->string('retrato_caminho')->nullable();
            $table->boolean('revelada')->default(false);    // NPC: mostra campos "publico" aos jogadores
            $table->json('valores');
            $table->timestamps();
        });

        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cena_id')->constrained('itens_biblioteca')->cascadeOnDelete(); // item tipo cena
            $table->foreignId('ficha_id')->constrained('fichas')->cascadeOnDelete();         // obrigatório no MVP
            $table->unsignedSmallInteger('coluna');
            $table->unsignedSmallInteger('linha');
            $table->boolean('visivel_para_jogadores')->default(true);
            $table->timestamps();

            $table->index(['cena_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tokens');
        Schema::dropIfExists('fichas');
    }
};
