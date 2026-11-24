@extends('layouts.app')

@section('titulo', $sistema->nome)
@section('trilha')
    <a href="{{ route('sistemas.index') }}">Sistemas</a> · {{ $sistema->nome }}
@endsection
@section('capitulo', 'Visão geral')

@section('faixa')
    <div class="flex flex-wrap items-end justify-between gap-6">
        <div class="flex items-end gap-5">
            @include('sistemas.partials.lombada')
            <div class="flex flex-col items-start gap-1">
                <span class="sobrelinha">{{ $sistema->editora }}</span>
                <h1 class="text-4xl tracking-[0.1em] sm:text-5xl md:text-[68px]">{{ $sistema->nome }}</h1>
                <span class="etiqueta mt-1">Visão geral</span>
            </div>
        </div>

        @if (Route::has('personagens.create'))
            <a href="{{ route('personagens.create', ['sistema' => $sistema->slug]) }}" class="btn">Criar ficha de {{ $sistema->nome }}</a>
        @endif
    </div>

    @include('sistemas.partials.abas')
@endsection

@section('conteudo')
    <div class="flex flex-wrap items-start gap-12">
        <div class="flex min-w-0 flex-[999_1_600px] flex-col gap-12">
            {{-- Arte do sistema --}}
            <figure class="polaroide -rotate-[0.8deg]">
                <span class="fita" style="left: 40px; margin-left: 0; width: 130px; transform: rotate(-4deg);" aria-hidden="true"></span>
                <span class="fita fita-vermelha" style="left: auto; right: 40px; margin-left: 0; width: 110px; transform: rotate(4deg);" aria-hidden="true"></span>
                <img src="{{ asset($sistema->capa) }}" alt="{{ $sistema->capa_alt }}"
                     class="block h-[340px] w-full object-cover" style="object-position: {{ $sistema->capa_posicao }}">
                <figcaption><span class="text-vermelho">{{ $sistema->nome }} · livro básico</span><span>Arte: {{ $sistema->editora }}</span></figcaption>
            </figure>

            {{-- Sobre --}}
            <section class="flex flex-col gap-4">
                <h2 class="barras text-4xl">Sobre o sistema</h2>
                @foreach ($sistema->sobre as $paragrafo)
                    @if ($loop->first)
                        <p class="text-xl leading-[1.7] text-[#2c2420]"><span class="float-left mt-1 mr-3 text-[78px] leading-[0.8] font-bold text-vermelho">{{ mb_substr($paragrafo, 0, 1) }}</span>{{ mb_substr($paragrafo, 1) }}</p>
                    @else
                        <p class="text-lg leading-[1.7] text-tinta-2">{{ $paragrafo }}</p>
                    @endif
                @endforeach
            </section>

            <section class="flex flex-wrap gap-8">
                {{-- Para jogar --}}
                <div class="flex flex-[1_1_320px] flex-col gap-4">
                    <h3 class="barras text-3xl">Para jogar</h3>
                    <ul class="border-t-2 border-tinta">
                        @foreach ($sistema->para_jogar as $item)
                            <li class="flex items-baseline gap-3.5 border-b border-linha py-3">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="#a8191f" class="shrink-0" aria-hidden="true"><path d="M12 2l9 10-9 10-9-10z"/></svg>
                                <span class="text-lg leading-normal">{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- O que a RollNacional faz por ele --}}
                <article class="flex flex-[1_1_340px] flex-col gap-4 bg-vermelho-faixa p-7 text-[#fbf3e6]">
                    <div class="flex flex-wrap items-center justify-between gap-2.5">
                        <h3 class="text-[26px] tracking-[0.08em]">Na RollNacional</h3>
                        <span class="border border-dashed border-dourado-claro px-3 py-1 font-rotulo text-xs font-semibold uppercase tracking-[0.16em] text-dourado-claro">Recursos</span>
                    </div>
                    <ul class="flex flex-col gap-3 text-lg leading-normal text-[#f6e2d9]">
                        @foreach ($sistema->recursos as $recurso)
                            <li>{{ $recurso }}</li>
                        @endforeach
                    </ul>
                </article>
            </section>
        </div>

        <aside class="flex flex-[1_1_300px] flex-col gap-6 md:sticky md:top-6 md:max-w-[380px]">
            <div class="border border-t-4 border-linha border-t-dourado bg-marfim px-6 pt-6 pb-5">
                <p class="sobrelinha mb-2 text-[13px] tracking-[0.24em]">Ficha técnica</p>
                <ul>
                    @foreach ($sistema->ficha_tecnica as $rotulo => $valor)
                        <li class="flex items-baseline gap-3 border-b border-linha py-2.5">
                            <span class="rotulo">{{ $rotulo }}</span>
                            <span class="pontilhado" aria-hidden="true"></span>
                            <span class="text-right text-[17px] font-semibold">{{ $valor }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            @if (Route::has('sistemas.compendio'))
                <a href="{{ route('sistemas.compendio', $sistema->slug) }}" class="btn-sec w-full">Abrir compêndio</a>
            @endif

            <div class="bilhete rotate-[1.2deg]">
                <span class="fita" aria-hidden="true"></span>
                <p class="rotulo mb-1.5 text-xs text-vermelho">Suas fichas</p>
                <p>
                    Os personagens que você criar em {{ $sistema->nome }} aparecem em Personagens.
                    @if (Route::has('personagens.index'))
                        <a href="{{ route('personagens.index') }}">Ver personagens</a>
                    @endif
                </p>
            </div>
        </aside>
    </div>
@endsection
