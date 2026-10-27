<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sistemas_jogo', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 120);
            $table->string('slug', 140)->unique()->nullable();
            $table->string('editora', 120)->nullable();
            $table->text('descricao')->nullable();
            $table->string('capa_caminho')->nullable();
            $table->string('site_oficial')->nullable();
            $table->text('aviso_licenca')->nullable();
            $table->string('status')
                ->default('rascunho')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sistemas_jogo');
    }
};
