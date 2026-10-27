{{-- Login. Rotas: autenticacao.login (GET) → autenticacao.entrar.enviar (POST). Campos: email, senha, lembrar (checkbox "Manter conectado"). --}}
@extends('layouts.visitante')
@section('titulo', 'Entrar')
@section('conteudo')
    <div>
        <h2>Entrar</h2>
        <p>Use o e-mail e a senha da sua conta.</p>
    </div>
    <form method="POST" action="{{ route('autenticacao.entrar.enviar') }}">
        @csrf
        <label for="email" class="campo">E-mail
            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="entrada" placeholder="voce@exemplo.com" autocomplete="email" autofocus>
        </label>
        <label for="senha" class="campo">Senha
            <input type="password" id="senha" name="senha" required class="entrada" autocomplete="current-password">
        </label>
        <label class="marcar">
            <input type="checkbox" name="lembrar" value="1" class="caixa" @checked(old('lembrar'))>
            Manter conectado
        </label>
        <button type="submit" class="botao botao--primario botao--largo">Entrar</button>
    </form>
    <div class="ou">ou</div>
    <a href="{{ route('autenticacao.cadastro') }}" class="botao botao--contorno botao--largo">Criar uma conta</a>
@endsection
