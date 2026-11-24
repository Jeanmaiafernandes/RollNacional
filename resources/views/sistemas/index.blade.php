@extends('layouts.app')

@section('titulo', 'Sistemas')

@section('conteudo')
    {{-- Título, filtro por origem e a estante --}}
    <div class="flex flex-wrap items-end justify-between gap-x-16 gap-y-10">
        <div class="flex flex-[1_1_440px] flex-col gap-7 md:pb-5">
            <div class="flex max-w-[32em] flex-col gap-2.5">
                <h1 class="text-5xl leading-none tracking-normal normal-case md:text-[64px]">Sistemas</h1>
                <p class="text-xl leading-relaxed text-tinta-2">Os livros que já têm ficha e compêndio por aqui. Abra um para ler as regras ou criar um personagem.</p>
            </div>

            <nav aria-label="Filtrar por origem" class="filtro">
                <a href="{{ route('sistemas.index') }}" @if (! $origem) aria-current="page" @endif>Todos</a>
                @foreach ($origens as $valor => $texto)
                    <a href="{{ route('sistemas.index', ['origem' => $valor]) }}" @if ($origem === $valor) aria-current="page" @endif>{{ $texto }}</a>
                @endforeach
            </nav>
        </div>

        <div class="max-w-full overflow-x-auto">
            <div class="estante">
                @foreach ($sistemas as $sistema)
                    <a href="{{ route('sistemas.show', $sistema->slug) }}" class="livro"
                       style="--cor: {{ $sistema->cor }}; --altura: {{ 300 - ($loop->index % 4) * 21 }}px;">
                        <span class="livro-filete" aria-hidden="true"></span>
                        <span class="livro-titulo">{{ $sistema->nome }}</span>
                        <span class="font-rotulo text-sm text-dourado-claro" aria-hidden="true">{{ $sistema->sigla }}</span>
                    </a>
                @endforeach

                @if (Route::has('sistemas.sugerir'))
                    <a href="{{ route('sistemas.sugerir') }}" class="livro-vaga"><span>Sugerir um sistema</span></a>
                @else
                    <span class="livro-vaga" aria-hidden="true"><span>Mais sistemas em breve</span></span>
                @endif
            </div>
        </div>
    </div>

    {{-- Lista --}}
    @if ($sistemas->isEmpty())
        <div class="flex flex-col items-start gap-3 border-t-2 border-tinta pt-8">
            <p class="text-lg text-tinta-2">Ainda não há sistemas {{ Str::lower($origens[$origem] ?? 'publicados') }} na estante.</p>
            @if ($origem)
                <a href="{{ route('sistemas.index') }}" class="btn-contorno">Ver todos os sistemas</a>
            @endif
        </div>
    @else
        <ul class="border-t-2 border-tinta">
            @foreach ($sistemas as $sistema)
                <li class="grid grid-cols-[12px_minmax(0,1fr)] items-end gap-x-9 gap-y-6 border-b border-linha py-8 md:grid-cols-[12px_minmax(0,1fr)_96px_170px_200px]">
                    <span aria-hidden="true" class="row-span-3 min-h-24 self-stretch rounded-[3px] shadow-[inset_-4px_0_0_rgba(0,0,0,0.2)] md:row-span-1"
                          style="background: {{ $sistema->cor }}"></span>

                    <div class="flex min-w-0 flex-col gap-2">
                        <div>
                            <h2 class="text-[32px] leading-tight tracking-normal normal-case">
                                <a href="{{ route('sistemas.show', $sistema->slug) }}" class="text-tinta no-underline hover:text-vermelho">{{ $sistema->nome }}</a>
                            </h2>
                            @if ($sistema->editora)
                                <span class="legenda text-base">{{ $sistema->editora }}</span>
                            @endif
                        </div>
                        @if ($sistema->resumo)
                            <p class="max-w-[38em] text-lg leading-relaxed text-tinta-2">{{ $sistema->resumo }}</p>
                        @endif
                    </div>

                    <div class="col-start-2 flex gap-7 md:contents">
                        @if ($sistema->dado)
                            <div class="campo-ficha w-24">
                                <span class="font-rotulo text-2xl font-medium">{{ $sistema->dado }}</span>
                                <span class="legenda">dado da mesa</span>
                            </div>
                        @else
                            <span class="hidden md:block" aria-hidden="true"></span>
                        @endif
                        <div class="campo-ficha flex-1">
                            <span class="text-[19px] font-semibold">{{ $sistema->situacao_ficha }}</span>
                            <span class="legenda">ficha automática</span>
                        </div>
                    </div>

                    <a href="{{ route('sistemas.show', $sistema->slug) }}" class="btn-contorno col-start-2 justify-self-start md:col-start-auto md:justify-self-end">Abrir {{ $sistema->nome }}</a>
                </li>
            @endforeach
        </ul>
    @endif

    @if (Route::has('sistemas.sugerir'))
        <p class="text-[17px] text-tinta-2">Não achou o sistema da sua mesa? <a href="{{ route('sistemas.sugerir') }}">Sugira um sistema</a> e diga onde encontrar o livro.</p>
    @endif
@endsection
