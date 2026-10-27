<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('versoes_sistema', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sistema_jogo_id')->constrained('sistemas_jogo')->restrictOnDelete();            $table->string('numero', 20);                 // "1.0", "1.1"
            $table->text('notas_alteracao')->nullable();
            $table->json('estruturas');                   // { "pj": {...}, "npc": {...} }
            $table->json('configuracao')->nullable();
            $table->foreignId('baseado_em_id')->nullable()->constrained('versoes_sistema')->nullOnDelete();
            $table->string('status', 20)->default('rascunho'); // StatusVersao
            $table->timestamp('publicada_em')->nullable();
            $table->timestamps();

            $table->unique(['sistema_jogo_id', 'numero']);
            $table->index(['sistema_jogo_id', 'status', 'publicada_em']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('versoes_sistema');
    }
};
