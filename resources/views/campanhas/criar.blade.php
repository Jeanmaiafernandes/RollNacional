{{-- Nova campanha. Rota: campanhas.criar (GET) → campanhas.salvar (POST). Espera $sistemas publicados. --}}
@extends('layouts.app')
@section('titulo', 'Nova campanha')
@section('conteudo')
    <a href="{{ route('inicio') }}" class="voltar">@include('parciais.icone', ['nome' => 'voltar', 'tamanho' => 14, 'espessura' => 2.5]) Minhas campanhas</a>

    <header class="cabecalho">
        <div>
            <h1>Nova campanha</h1>
            <p>Você será o mestre. O código de convite é gerado automaticamente; a senha quem define é você.</p>
        </div>
    </header>

    <form method="POST" action="{{ route('campanhas.salvar') }}" class="grade grade--3">
        @csrf
        <section class="painel grade__2col" style="gap: 16px">
            @include('campanhas.parciais.formulario', ['campanha' => null])
        </section>

        <section class="painel" style="gap: 16px">
            <h2 class="painel__titulo">Senha da mesa</h2>
            <label for="senha" class="campo">Senha
                <input type="password" id="senha" name="senha" required minlength="4" class="entrada" autocomplete="new-password">
            </label>
            <label for="senha_confirmation" class="campo">Repita a senha
                <input type="password" id="senha_confirmation" name="senha_confirmation" required class="entrada" autocomplete="new-password">
            </label>
            <span class="apagado pequeno">Quem tiver o código e a senha entra como espectador; você define o papel depois.</span>
            <button type="submit" class="botao botao--primario botao--largo">Criar campanha</button>
        </section>
    </form>
@endsection
