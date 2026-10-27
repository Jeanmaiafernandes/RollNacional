{{-- Perfil. Rotas: perfil (GET), perfil.atualizar (PUT nome/email), perfil.senha.atualizar (PUT senha_atual, senha, senha_confirmation). --}}
@extends('layouts.app')
@section('titulo', 'Perfil')
@section('conteudo')
    @php $usuario = auth()->user(); @endphp
    <header class="cabecalho">
        <div>
            <h1>Perfil</h1>
            <p>Seus dados de acesso. O que você é em cada mesa (mestre, jogador…) é definido campanha a campanha.</p>
        </div>
    </header>

    <div class="grade grade--2">
        <form method="POST" action="{{ route('perfil.atualizar') }}" class="painel" style="gap: 16px">
            @csrf @method('PUT')
            <h2 class="painel__titulo">Dados</h2>
            <label for="nome" class="campo">Nome
                <input type="text" id="nome" name="nome" value="{{ old('nome', $usuario->nome) }}" required maxlength="80" class="entrada">
            </label>
            <label for="email" class="campo">E-mail
                <input type="email" id="email" name="email" value="{{ old('email', $usuario->email) }}" required class="entrada">
            </label>
            <div class="acoes" style="margin-top: 4px">
                <button type="submit" class="botao botao--primario">Salvar dados</button>
            </div>
        </form>

        <form method="POST" action="{{ route('perfil.senha.atualizar') }}" class="painel" style="gap: 16px">
            @csrf @method('PUT')
            <h2 class="painel__titulo">Trocar senha</h2>
            <label for="senha_atual" class="campo">Senha atual
                <input type="password" id="senha_atual" name="senha_atual" required class="entrada" autocomplete="current-password">
            </label>
            <label for="senha" class="campo">Nova senha
                <input type="password" id="senha" name="senha" required minlength="8" class="entrada" autocomplete="new-password">
            </label>
            <label for="senha_confirmation" class="campo">Repita a nova senha
                <input type="password" id="senha_confirmation" name="senha_confirmation" required class="entrada" autocomplete="new-password">
            </label>
            <div class="acoes" style="margin-top: 4px">
                <button type="submit" class="botao botao--contorno">Trocar senha</button>
            </div>
        </form>

        <section class="painel grade__2col">
            <h2 class="painel__titulo">Conta</h2>
            <div class="dados">
                <div><span>Membro desde</span><span>{{ $usuario->created_at->format('d/m/Y') }}</span></div>
                <div><span>Campanhas</span><span>{{ $usuario->campanhas()->count() }}</span></div>
                <div><span>Personagens na conta</span><span>{{ $usuario->personagens()->count() }}</span></div>
            </div>
        </section>
    </div>
@endsection
