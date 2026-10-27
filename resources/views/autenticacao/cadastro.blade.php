{{-- Cadastro. Rotas: autenticacao.cadastro (GET) → autenticacao.cadastro.enviar (POST). Campos: nome, email, senha, senha_confirmation. --}}
@extends('layouts.visitante')
@section('titulo', 'Criar uma conta')
@section('conteudo')
    <div>
        <h2>Criar uma conta</h2>
        <p>Leva um minuto. Depois é só entrar numa mesa ou criar a sua.</p>
    </div>
    <form method="POST" action="{{ route('autenticacao.cadastro.enviar') }}">
        @csrf
        <label for="nome" class="campo">Nome
            <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required maxlength="80" class="entrada" autocomplete="name" autofocus>
        </label>
        <label for="email" class="campo">E-mail
            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="entrada" placeholder="voce@exemplo.com" autocomplete="email">
        </label>
        <label for="senha" class="campo">Senha
            <input type="password" id="senha" name="senha" required minlength="8" class="entrada" autocomplete="new-password">
            <span class="apagado" style="font-weight: 400; font-size: 12px">Pelo menos 8 caracteres.</span>
        </label>
        <label for="senha_confirmation" class="campo">Repita a senha
            <input type="password" id="senha_confirmation" name="senha_confirmation" required class="entrada" autocomplete="new-password">
        </label>
        <button type="submit" class="botao botao--primario botao--largo">Criar conta</button>
    </form>
    <div class="ou">ou</div>
    <a href="{{ route('autenticacao.login') }}" class="botao botao--contorno botao--largo">Já tenho conta — entrar</a>
@endsection
