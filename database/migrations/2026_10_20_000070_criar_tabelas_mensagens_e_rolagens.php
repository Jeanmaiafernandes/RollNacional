<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campanha_id')->constrained('campanhas')->cascadeOnDelete();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('ficha_id')->nullable()->constrained('fichas')->nullOnDelete(); // fala "como" o personagem
            $table->text('texto');
            $table->timestamps();

            $table->index(['campanha_id', 'created_at']);
        });

        Schema::create('rolagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campanha_id')->constrained('campanhas')->cascadeOnDelete();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('ficha_id')->nullable()->constrained('fichas')->nullOnDelete();
            $table->string('expressao');
            $table->string('rotulo')->nullable();
            $table->integer('total');
            $table->json('detalhes');
            $table->boolean('secreta')->default(false);
            $table->timestamps();

            $table->index(['campanha_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rolagens');
        Schema::dropIfExists('mensagens');
    }
};
