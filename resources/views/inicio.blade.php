@extends('layouts.app')

@php
    $usuario = auth()->user();
    $primeiroNome = strtok($usuario->nome ?? '', ' ');
    $hora = (int) now()->format('G');
    $saudacao = $hora < 12 ? 'Bom dia' : ($hora < 18 ? 'Boa tarde' : 'Boa noite');
    $novaFicha = Route::has('personagens.create') ? route('personagens.create') : null;
@endphp

@section('titulo', 'Início')
@section('trilha', 'Início')

@section('faixa')
    <div class="flex flex-wrap items-end justify-between gap-6">
        <div class="flex flex-col items-start gap-2">
            <span class="sobrelinha">{{ ucfirst(now()->translatedFormat('l, j \d\e F')) }}</span>
            <h1 class="text-5xl md:text-6xl">{{ $saudacao }}, <span class="text-vermelho">{{ $primeiroNome }}</span></h1>
            <span class="etiqueta mt-1">A mesa está posta</span>
        </div>

        <div class="flex flex-wrap gap-3">
            @if ($novaFicha)
                <a href="{{ $novaFicha }}" class="btn">+ Nova ficha</a>
            @endif
            @if (Route::has('personagens.index'))
                <a href="{{ route('personagens.index') }}" class="btn-sec">Meus personagens</a>
            @endif
        </div>
    </div>
@endsection

@section('conteudo')
    {{-- Fichas recentes: por enquanto sempre vazio --}}
    <section class="flex flex-col gap-6">
        <h2 class="barras text-3xl md:text-4xl">Continuar de onde parou</h2>

        <div class="grid gap-6 md:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)]">
            <div class="bilhete flex -rotate-[0.6deg] flex-col items-start gap-3 px-7 pt-8 pb-7">
                <span class="fita" style="width: 100px; margin-left: -50px;" aria-hidden="true"></span>
                <p class="rotulo text-xs text-vermelho">Nenhuma ficha ainda</p>
                <p>Suas fichas aparecem aqui, das mais recentes para as mais antigas. Escolha um sistema e monte a primeira.</p>
                @if ($novaFicha)
                    <a href="{{ $novaFicha }}" class="btn mt-2">Criar primeira ficha</a>
                @endif
            </div>

            <a href="{{ $novaFicha ?? '#' }}" class="flex min-h-48 flex-col items-center justify-center gap-2.5 border-2 border-dashed border-pontilhado bg-[#fffdf8] text-tinta no-underline hover:text-tinta">
                <span class="flex size-11 items-center justify-center rounded-full bg-vermelho text-[28px] leading-none text-white" aria-hidden="true">+</span>
                <span class="link-rotulo text-[15px] text-tinta">Nova ficha</span>
            </a>
        </div>
    </section>

    <section class="flex flex-wrap gap-10">
        {{-- Sistemas: texto fixo até a tabela de sistemas existir --}}
        <div class="flex flex-[999_1_560px] flex-col gap-6">
            <h2 class="barras text-3xl md:text-4xl">Sistemas</h2>

            <div class="grid gap-6 sm:grid-cols-2">
                <article class="flex flex-col border-2 border-tinta bg-papel">
                    <img src="{{ asset('img/sistemas/capa-tormenta20.webp') }}" alt="" class="block h-[150px] w-full border-b-2 border-tinta object-cover object-[center_28%]">
                    <div class="flex items-center justify-between gap-3 px-[18px] py-3.5">
                        <h3 class="text-2xl tracking-[0.05em]">Tormenta20</h3>
                        <span class="text-[15px] italic text-dourado-texto">Jambô Editora</span>
                    </div>
                </article>

                <article class="flex flex-col border-2 border-tinta bg-papel">
                    <img src="{{ asset('img/sistemas/capa-dnd5e.webp') }}" alt="" class="block h-[150px] w-full border-b-2 border-tinta object-cover object-[center_30%]">
                    <div class="flex items-center justify-between gap-3 px-[18px] py-3.5">
                        <h3 class="text-2xl tracking-[0.05em]">D&amp;D 5e</h3>
                        <span class="text-[15px] italic text-dourado-texto">Wizards of the Coast</span>
                    </div>
                </article>
            </div>
        </div>

        <aside class="flex flex-[1_1_300px] flex-col gap-6 pt-1.5">
            <p class="sobrelinha text-[13px] tracking-[0.24em]">Quadro de avisos</p>
            <div class="bilhete -rotate-[1.5deg]">
                <span class="fita" aria-hidden="true"></span>
                <p class="rotulo mb-1.5 text-xs text-vermelho">Próxima etapa</p>
                <p>A mesa virtual, com mapa e rolagens compartilhadas, chega na etapa 2.</p>
            </div>
            <div class="bilhete rotate-[1.2deg]">
                <span class="fita fita-vermelha" aria-hidden="true"></span>
                <p class="rotulo mb-1.5 text-xs text-vermelho">Seu perfil</p>
                <p>
                    Coloque foto e apresentação para os outros jogadores te reconhecerem.
                    @if (Route::has('conta.perfil'))
                        <a href="{{ route('conta.perfil') }}">Editar perfil</a>
                    @endif
                </p>
            </div>
        </aside>
    </section>
@endsection
