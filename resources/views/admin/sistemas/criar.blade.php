{{-- Admin: novo sistema. Rotas: admin.sistemas.criar (GET) → admin.sistemas.salvar (POST). Começa como rascunho, sem versão. --}}
@extends('layouts.app')
@section('titulo', 'Novo sistema')
@section('conteudo')
    <a href="{{ route('admin.sistemas.listar') }}" class="voltar">@include('parciais.icone', ['nome' => 'voltar', 'tamanho' => 14, 'espessura' => 2.5]) Sistemas</a>
    <header class="cabecalho">
        <div>
            <h1>Novo sistema</h1>
            <p>Cadastre as informações; a estrutura da ficha vem depois, na primeira versão.</p>
        </div>
    </header>
    <form method="POST" action="{{ route('admin.sistemas.salvar') }}" class="painel" enctype="multipart/form-data" style="gap: 20px">
        @csrf
        @include('admin.sistemas.parciais.formulario', ['sistema' => null])
        <div class="acoes">
            <button type="submit" class="botao botao--primario">Criar sistema</button>
            <a href="{{ route('admin.sistemas.listar') }}" class="botao botao--contorno">Cancelar</a>
        </div>
    </form>
@endsection
