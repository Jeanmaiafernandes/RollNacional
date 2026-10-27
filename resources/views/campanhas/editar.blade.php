{{-- Editar campanha (só mestre). Rotas: campanhas.editar (GET) → campanhas.atualizar (PUT). Nova senha opcional: envie vazio para manter. --}}
@extends('layouts.app')
@section('titulo', 'Editar · ' . $campanha->nome)
@section('conteudo')
    <a href="{{ route('campanhas.exibir', $campanha) }}" class="voltar">@include('parciais.icone', ['nome' => 'voltar', 'tamanho' => 14, 'espessura' => 2.5]) {{ $campanha->nome }}</a>

    <header class="cabecalho">
        <div>
            <h1>Editar campanha</h1>
            <p>Código de convite: <code class="mono" style="color: #fff; letter-spacing: 2px">{{ $campanha->codigo_convite }}</code></p>
        </div>
    </header>

    <form method="POST" action="{{ route('campanhas.atualizar', $campanha) }}" class="grade grade--3">
        @csrf @method('PUT')
        <section class="painel grade__2col" style="gap: 16px">
            @include('campanhas.parciais.formulario', ['campanha' => $campanha, 'sistemas' => collect()])
            <div class="acoes">
                <button type="submit" class="botao botao--primario">Salvar alterações</button>
                <a href="{{ route('campanhas.exibir', $campanha) }}" class="botao botao--contorno">Cancelar</a>
            </div>
        </section>

        <section id="senha" class="painel painel--destaque" style="gap: 16px">
            <h2 class="painel__titulo">Redefinir senha</h2>
            <span class="fraco pequeno" style="font-size: 13px">A senha atual não pode ser vista. Deixe em branco para manter.</span>
            <label for="senha" class="campo">Nova senha
                <input type="password" id="senha" name="senha" minlength="4" class="entrada" autocomplete="new-password">
            </label>
            <label for="senha_confirmation" class="campo">Repita a nova senha
                <input type="password" id="senha_confirmation" name="senha_confirmation" class="entrada" autocomplete="new-password">
            </label>
        </section>
    </form>
@endsection
