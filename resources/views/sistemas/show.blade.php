@extends('layouts.app')

{{--
    Página de um sistema, aba Visão geral. A estrutura é a mesma para todos:
    - do banco: nome, editora, cor, sigla, capa, descrição, dado e licença;
    - de sistemas/conteudo/{slug}/ (cada arquivo é opcional):
        principal.blade.php  "Para jogar" e "Na RollNacional", depois de "Sobre o sistema"
        lateral.blade.php    linhas extras da ficha técnica
--}}

@php
    $pasta = 'sistemas.conteudo.'.$sistema->slug;
    $paragrafos = preg_split('/\n\s*\n/', trim((string) $sistema->descricao), -1, PREG_SPLIT_NO_EMPTY);
    if ($paragrafos === []) {
        $paragrafos = [$sistema->resumo ?? 'A descrição deste sistema ainda não foi escrita.'];
    }
    $temCompendio = Route::has('sistemas.compendio');
    $temModelo = Route::has('sistemas.modelo');

    // Capa deitada preenche a moldura; capa em pé (como a do Etmos) entra inteira, sem corte
    $capaVertical = false;
    if ($sistema->caminho_capa && is_file($arquivoCapa = storage_path('app/public/'.$sistema->caminho_capa))) {
        [$larguraCapa, $alturaCapa] = getimagesize($arquivoCapa) ?: [1, 0];
        $capaVertical = $alturaCapa > $larguraCapa;
    }
@endphp

@section('titulo', $sistema->nome)

@section('conteudo')
    {{-- Faixa do topo: trilha, título e abas --}}
    <div class="flex flex-col gap-4 border-y border-linha bg-[#f7f2ea] px-5 pt-4 md:px-8">
        <div class="flex flex-wrap justify-between gap-2 font-rotulo text-xs uppercase tracking-[0.12em]">
            <nav aria-label="Trilha" class="text-tinta-3">
                <a href="{{ route('sistemas.index') }}">Sistemas</a> / {{ $sistema->nome }}
            </nav>
            <span class="font-semibold text-vermelho">Capítulo: Visão geral</span>
        </div>

        <div class="flex flex-wrap items-center gap-x-6 gap-y-4">
            <span class="livro livro-pequeno" style="--cor: {{ $sistema->cor }}" aria-hidden="true">
                <span class="livro-filete"></span>
                <span class="livro-titulo">{{ $sistema->nome }}</span>
                <span class="font-rotulo text-sm text-dourado-claro">{{ $sistema->sigla }}</span>
            </span>

            <div class="flex min-w-0 flex-[1_1_280px] flex-col gap-1">
                @if ($sistema->editora)
                    <span class="font-rotulo text-xs font-semibold uppercase tracking-[0.16em] text-[#8a6416]">{{ $sistema->editora }}</span>
                @endif
                <h1 class="text-4xl leading-none md:text-[52px]">{{ $sistema->nome }}</h1>
                <span class="mt-1 self-start bg-tinta px-2.5 py-0.5 font-rotulo text-xs font-semibold uppercase tracking-[0.16em] text-dourado-claro">Visão geral</span>
            </div>

            @if (Route::has('personagens.create'))
                <a href="{{ route('personagens.create', ['sistema' => $sistema->slug]) }}" class="btn-cheio">Criar ficha de {{ $sistema->nome }}</a>
            @endif
        </div>

        <nav aria-label="Seções do sistema" class="flex flex-wrap gap-x-6 font-rotulo text-sm font-semibold uppercase tracking-[0.12em]">
            <a href="{{ route('sistemas.show', $sistema) }}" aria-current="page" class="pb-2.5 pt-2 text-tinta no-underline shadow-[inset_0_-2px_0_var(--color-vermelho)]">Visão geral</a>
            @if ($temCompendio)
                <a href="{{ route('sistemas.compendio', $sistema) }}" class="pb-2.5 pt-2 text-tinta-3 no-underline hover:text-tinta">Compêndio</a>
            @endif
            @if ($temModelo)
                <a href="{{ route('sistemas.modelo', $sistema) }}" class="pb-2.5 pt-2 text-tinta-3 no-underline hover:text-tinta">Modelo de ficha</a>
            @endif
        </nav>
    </div>

    <div class="mt-10 flex flex-wrap items-start gap-10">
        {{-- Coluna principal --}}
        <div class="flex min-w-0 flex-[999_1_560px] flex-col gap-10">
            @if ($sistema->caminho_capa)
                <figure class="relative mx-1 mt-1.5 -rotate-[0.6deg] bg-white px-3 pb-2.5 pt-3 shadow-[0_10px_28px_rgba(35,26,20,0.16)]">
                    <span aria-hidden="true" class="absolute -top-2.5 left-6 h-6 w-24 -rotate-[4deg] bg-dourado/40"></span>
                    <span aria-hidden="true" class="absolute -top-2.5 right-6 h-6 w-20 rotate-[5deg] bg-dourado/40"></span>
                    <img src="{{ asset('storage/'.$sistema->caminho_capa) }}" alt="Capa de {{ $sistema->nome }}"
                        @class([
                            'block aspect-[2/1] w-full',
                            'bg-[#f7f2ea] object-contain' => $capaVertical,
                            'object-cover object-[center_28%]' => ! $capaVertical,
                        ])>
                    <figcaption class="flex flex-wrap justify-between gap-1.5 pt-2.5 font-rotulo text-[11px] uppercase tracking-[0.14em] text-tinta-3">
                        <span class="text-tinta">{{ $sistema->nome }}</span>
                        @if ($sistema->editora)
                            <span>Arte: {{ $sistema->editora }}</span>
                        @endif
                    </figcaption>
                </figure>
            @endif

            <section aria-labelledby="sobre-titulo" class="flex max-w-[40em] flex-col gap-3">
                <h2 id="sobre-titulo" class="flex items-center gap-3">
                    Sobre o sistema
                    @include('sistemas.partials.marca')
                </h2>
                @foreach ($paragrafos as $paragrafo)
                    <p @class([
                        'text-lg leading-[1.65] text-tinta first-letter:float-left first-letter:pr-2 first-letter:pt-1 first-letter:text-[64px] first-letter:font-bold first-letter:leading-[0.8] first-letter:text-vermelho' => $loop->first,
                        'leading-[1.65] text-tinta-2' => ! $loop->first,
                    ])>{{ $paragrafo }}</p>
                @endforeach
            </section>

            @includeIf($pasta.'.principal')
        </div>

        {{-- Lateral --}}
        <aside aria-label="Resumo do sistema" class="flex w-full flex-col gap-5 md:max-w-[320px] md:flex-[1_1_260px]">
            <section aria-labelledby="ficha-tecnica" class="relative border border-linha bg-[#f7f2ea] px-5 pb-3 pt-6">
                <span aria-hidden="true" class="absolute -top-2.5 left-1/2 h-5 w-20 -translate-x-1/2 -rotate-2 bg-dourado/45"></span>
                <h2 id="ficha-tecnica" class="mb-1 font-rotulo text-xs font-semibold uppercase tracking-[0.16em] text-vermelho">Ficha técnica</h2>
                <dl>
                    @include('sistemas.partials.linha-ficha', ['rotulo' => 'Editora', 'valor' => $sistema->editora])
                    @include('sistemas.partials.linha-ficha', ['rotulo' => 'Dado', 'valor' => $sistema->dado])
                    @includeIf($pasta.'.lateral')
                    @include('sistemas.partials.linha-ficha', ['rotulo' => 'Licença', 'valor' => $sistema->licenca])
                </dl>
            </section>

            @if ($temCompendio)
                <a href="{{ route('sistemas.compendio', $sistema) }}" class="btn-contorno w-full">Abrir compêndio</a>
            @endif

            <div class="rotate-1 border border-[#efe1bc] bg-[#fff8e6] p-4 shadow-[0_6px_14px_rgba(35,26,20,0.1)]">
                <p class="mb-1 font-rotulo text-xs font-semibold uppercase tracking-[0.14em] text-vermelho">Suas fichas aqui</p>
                <p class="text-sm italic text-tinta-2">
                    Seus personagens deste sistema ficam em Personagens.
                    @if (Route::has('personagens.index'))
                        <a href="{{ route('personagens.index', ['sistema' => $sistema->slug]) }}">Ver personagens</a>
                    @endif
                </p>
            </div>
        </aside>
    </div>
@endsection
