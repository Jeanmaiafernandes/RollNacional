{{--
    Novo personagem na conta. Rota: personagens.criar?sistema=slug&tipo=pj|npc (GET) → personagens.salvar (POST).
    Espera: $sistema (SistemaJogo), $tipo (TipoFicha), $estrutura (EstruturaFicha do sistema/tipo).
--}}
@extends('layouts.pagina')
@section('titulo', 'Novo personagem')
@section('conteudo')
    <header class="ficha-topo">
        <a href="{{ route('personagens.listar') }}" class="voltar">@include('parciais.icone', ['nome' => 'voltar', 'tamanho' => 14, 'espessura' => 2.5]) Meus personagens</a>
        <span class="apagado">/</span>
        <span style="font-size: 13px; color: var(--texto-medio)">{{ $sistema->nome }} · {{ $tipo->rotulo() }} · nova ficha</span>
        <div style="flex-grow: 1"></div>
        <a href="{{ route('personagens.listar') }}" class="botao botao--contorno" style="height: 40px">Cancelar</a>
        <button type="submit" form="form-ficha" class="botao botao--primario" style="height: 40px">Criar personagem</button>
    </header>

    <div style="max-width: 1200px; margin: 0 auto; padding: 20px 32px 0">@include('parciais.avisos')</div>

    <form id="form-ficha" method="POST" action="{{ route('personagens.salvar') }}" class="ficha-corpo" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="sistema" value="{{ $sistema->slug }}">
        <input type="hidden" name="tipo" value="{{ $tipo->value }}">
        @include('parciais.ficha.formulario', ['nome' => '', 'retrato' => null, 'estrutura' => $estrutura, 'valores' => [], 'rolar' => null])
    </form>
@endsection
