<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campanhas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mestre_id')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('sistema_jogo_id')->constrained('sistemas_jogo')->restrictOnDelete();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->string('codigo_convite', 8)->unique();
            $table->string('senha');                                   // hash
            $table->boolean('espectador_pode_escrever')->default(false); // gancho futuro
            // cena_ativa_id entra em migration posterior (itens_biblioteca ainda não existe)
            $table->timestamps();
        });

        Schema::create('campanha_usuario', function (Blueprint $table) {
            $table->foreignId('campanha_id')->constrained('campanhas')->cascadeOnDelete();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->string('papel', 20);                      // PapelCampanha
            $table->boolean('pode_criar_itens')->default(false);
            $table->timestamps();

            $table->primary(['campanha_id', 'usuario_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campanha_usuario');
        Schema::dropIfExists('campanhas');
    }
};
