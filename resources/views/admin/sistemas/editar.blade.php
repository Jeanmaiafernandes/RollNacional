{{-- Admin: editar informações do sistema. Rotas: admin.sistemas.editar (GET) → admin.sistemas.atualizar (PUT). Descontinuar = status obsoleto (não exclui). --}}
@extends('layouts.app')
@section('titulo', 'Editar · ' . $sistema->nome)
@section('conteudo')
    <a href="{{ route('admin.sistemas.listar', ['sistema' => $sistema->slug]) }}" class="voltar">@include('parciais.icone', ['nome' => 'voltar', 'tamanho' => 14, 'espessura' => 2.5]) {{ $sistema->nome }}</a>
    <header class="cabecalho">
        <div>
            <h1>Editar sistema</h1>
            <p>Mudar o slug quebra links já compartilhados. Versões e estrutura são editadas na tela do sistema.</p>
        </div>
    </header>
    <form method="POST" action="{{ route('admin.sistemas.atualizar', $sistema) }}" class="painel" enctype="multipart/form-data" style="gap: 20px">
        @csrf @method('PUT')
        @include('admin.sistemas.parciais.formulario', ['sistema' => $sistema])
        <div class="acoes">
            <button type="submit" class="botao botao--primario">Salvar</button>
            <a href="{{ route('admin.sistemas.listar', ['sistema' => $sistema->slug]) }}" class="botao botao--contorno">Cancelar</a>
        </div>
    </form>

    @if (Route::has('admin.sistemas.excluir'))
        <section class="painel painel--perigo faixa">
            <div class="faixa__texto">
                <h2>Excluir sistema</h2>
                <span>Só é possível se nenhuma campanha ou personagem usar este sistema. Prefira o status "obsoleto".</span>
            </div>
            <form method="POST" action="{{ route('admin.sistemas.excluir', $sistema) }}" onsubmit="return confirm('Excluir {{ $sistema->nome }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="botao botao--perigo" style="height: 40px">Excluir</button>
            </form>
        </section>
    @endif
@endsection
