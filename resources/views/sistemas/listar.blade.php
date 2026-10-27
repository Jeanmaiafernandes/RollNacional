{{-- Sistemas publicados (qualquer usuário logado). Rota: sistemas.listar. Espera $sistemas publicados com ->versoes. --}}
@extends('layouts.app')
@section('titulo', 'Sistemas')
@section('conteudo')
    <header class="cabecalho">
        <div>
            <h1>Sistemas de jogo</h1>
            <p>Sistemas disponíveis para criar campanhas e personagens. Não achou o seu? Use o sistema Livre.</p>
        </div>
        @can('administrar')
            <a href="{{ Route::has('admin.sistemas.listar') ? route('admin.sistemas.listar') : '#' }}" class="botao botao--contorno">Administrar sistemas</a>
        @endcan
    </header>

    <div class="grade grade--3">
        @foreach ($sistemas as $sistema)
            @php $versao = $sistema->versoes->where('status', \App\Enums\StatusVersao::Publicada)->sortByDesc('publicada_em')->first(); @endphp
            <article class="cartao">
                <div class="cartao__capa" style="height: 80px; align-items: center; gap: 10px">
                    @if ($sistema->capa_caminho)
                        <img src="{{ asset('storage/' . $sistema->capa_caminho) }}" alt="" style="height: 56px; border-radius: 6px">
                    @else
                        @include('parciais.icone', ['nome' => 'd20', 'tamanho' => 32, 'cor' => 'var(--primario)'])
                    @endif
                    <span class="selo selo--publicado">v{{ $versao?->numero ?? '—' }}</span>
                </div>
                <div class="cartao__corpo">
                    <h2>{{ $sistema->nome }}</h2>
                    <span class="fraco" style="font-size: 13px">{{ $sistema->editora ?: 'independente' }}@if ($sistema->modelo_base) · {{ $sistema->modelo_base }}@endif</span>
                    @if ($sistema->descricao)<p>{{ \Illuminate\Support\Str::limit($sistema->descricao, 120) }}</p>@endif
                    <div class="cartao__acoes">
                        <a href="{{ route('sistemas.exibir', $sistema) }}" class="botao botao--contorno">Ver ficha</a>
                        <a href="{{ route('personagens.criar', ['sistema' => $sistema->slug, 'tipo' => 'pj']) }}" class="botao botao--primario">Criar personagem</a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
@endsection
