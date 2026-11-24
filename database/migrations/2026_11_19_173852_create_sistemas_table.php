<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sistemas', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('slug', 100)->unique();
            $table->string('resumo')->nullable();
            $table->text('descricao')->nullable();
            $table->string('editora', 100)->nullable();
            $table->string('licenca', 100)->nullable();
            $table->string('origem', 20)->default('nacional'); // nacional | estrangeiro | independente
            $table->string('caminho_capa')->nullable();
            $table->boolean('publicado')->default(false);
            $table->timestamp('criado_em')->nullable();
            $table->timestamp('atualizado_em')->nullable();

            $table->index(['publicado', 'origem']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sistemas');
    }
};
