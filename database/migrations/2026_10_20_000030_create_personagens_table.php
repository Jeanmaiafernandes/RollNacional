<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Nível CONTA: personagens do usuário, sem campanha.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('sistema_jogo_id')->constrained('sistemas_jogo')->restrictOnDelete();
            $table->string('tipo', 10);                   // TipoFicha: pj | npc
            $table->string('nome');
            $table->string('retrato_caminho')->nullable();
            $table->json('valores');
            $table->boolean('publico')->default(false);   // gancho futuro (comunidade)
            $table->timestamps();

            $table->index(['usuario_id', 'tipo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personagens');
    }
};
