{{-- Detalhe de um sistema publicado. Rota: sistemas.exibir. Espera $sistema e $estruturas = ['pj' => EstruturaFicha, 'npc' => EstruturaFicha]. --}}
@extends('layouts.app')
@section('titulo', $sistema->nome)
@section('conteudo')
    <a href="{{ route('sistemas.listar') }}" class="voltar">@include('parciais.icone', ['nome' => 'voltar', 'tamanho' => 14, 'espessura' => 2.5]) Sistemas</a>

    <header class="cabecalho" style="align-items: flex-start">
        <div>
            <h1>{{ $sistema->nome }}</h1>
            <p>{{ $sistema->editora ?: 'independente' }}@if ($sistema->modelo_base) · {{ $sistema->modelo_base }}@endif
               @if ($sistema->site_oficial) · <a href="{{ $sistema->site_oficial }}" target="_blank" rel="noopener">site oficial</a>@endif</p>
        </div>
        <div class="acoes">
            <a href="{{ route('personagens.criar', ['sistema' => $sistema->slug, 'tipo' => 'npc']) }}" class="botao botao--contorno">Criar NPC</a>
            <a href="{{ route('personagens.criar', ['sistema' => $sistema->slug, 'tipo' => 'pj']) }}" class="botao botao--primario">Criar personagem</a>
        </div>
    </header>

    @if ($sistema->descricao || $sistema->aviso_licenca)
        <section class="painel">
            @if ($sistema->descricao)<p style="margin: 0; color: var(--texto-medio); line-height: 1.55">{{ $sistema->descricao }}</p>@endif
            @if ($sistema->aviso_licenca)<p style="margin: 0; color: var(--ambar); font-size: 13px">{{ $sistema->aviso_licenca }}</p>@endif
        </section>
    @endif

    <div class="grade grade--2">
        @foreach ($estruturas as $tipo => $estrutura)
            <section class="painel">
                <div class="painel__topo">
                    <h2 class="painel__titulo painel__titulo--secao">Ficha de {{ $tipo === 'npc' ? 'NPC / ameaça' : 'personagem' }}</h2>
                    <span class="selo selo--{{ $tipo }}">{{ strtoupper($tipo) }}</span>
                </div>
                @foreach (data_get($estrutura, 'secoes', method_exists($estrutura, 'secoes') ? $estrutura->secoes() : []) as $secao)
                    <div>
                        <strong style="font-size: 13px; color: #fff">{{ data_get($secao, 'titulo') }}</strong>
                        <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px">
                            @foreach (data_get($secao, 'campos', []) as $campo)
                                @php $t = data_get($campo, 'tipo'); $t = $t instanceof \BackedEnum ? $t->value : $t; @endphp
                                <span class="selo" style="color: var(--texto-medio)">{{ data_get($campo, 'rotulo', data_get($campo, 'chave')) }} <span class="apagado">· {{ $t }}</span></span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </section>
        @endforeach
    </div>
@endsection
