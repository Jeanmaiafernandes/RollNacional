<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('nome_usuario', 30)->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('senha');
            $table->rememberToken();
            $table->string('caminho_avatar')->nullable();
            $table->text('bio')->nullable();
            $table->string('papel_preferido', 20)->nullable(); // mestre | jogador | ambos
            $table->json('disponibilidade')->nullable();
            $table->boolean('eh_admin')->default(false);
            $table->string('plano', 20)->default('gratuito');
            $table->timestamp('criado_em')->nullable();
            $table->timestamp('atualizado_em')->nullable();
        });

        // Nome configurado em config/auth.php (passwords.users.table).
        Schema::create('tokens_redefinicao_senha', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('tokens_redefinicao_senha');
        Schema::dropIfExists('usuarios');
    }
};
