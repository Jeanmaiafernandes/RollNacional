@extends('layouts.app')

@php
    $ehDono = auth()->id() === $usuario->id;
    $mostrarPersonagens = $usuario->mostrar_personagens ?? true;
@endphp

@section('titulo', $usuario->nome)
@section('trilha', 'Usuários · '.$usuario->nome_usuario)

@section('faixa')
    <div class="flex flex-wrap items-end justify-between gap-6">
        <div class="flex flex-wrap items-center gap-7">
            <div class="relative -rotate-2 border border-linha bg-papel p-2.5 pb-6 shadow-[0_14px_26px_rgba(60,20,10,0.14)]">
                <span class="fita" aria-hidden="true"></span>
                <x-retrato :imagem="$usuario->caminho_avatar" tamanho="132" :alt="'Foto de '.$usuario->nome" />
            </div>

            <div class="flex max-w-[640px] flex-col items-start gap-2">
                <span class="font-rotulo text-[15px] font-semibold tracking-[0.16em] text-dourado-texto">{{ '@'.$usuario->nome_usuario }}</span>
                <h1 class="text-5xl md:text-6xl">{{ $usuario->nome }}</h1>
                <span class="text-[17px] italic text-tinta-3">Na mesa desde {{ $usuario->criado_em?->translatedFormat('F \d\e Y') }}</span>

                @if (filled($usuario->bio))
                    <p class="mt-2 text-lg leading-relaxed text-tinta-2">{{ $usuario->bio }}</p>
                @elseif ($ehDono)
                    <p class="mt-2 text-[17px] italic text-tinta-3">Você ainda não escreveu uma apresentação.</p>
                @endif
            </div>
        </div>

        @if ($ehDono && Route::has('conta.perfil'))
            <a href="{{ route('conta.perfil') }}" class="btn-sec">Editar perfil</a>
        @endif
    </div>
@endsection

@section('conteudo')
    @if ($mostrarPersonagens || $ehDono)
        <section class="flex flex-col gap-6">
            <h2 class="barras text-3xl md:text-4xl">Personagens</h2>

            {{-- Sem tabela de personagens ainda: estado vazio --}}
            <div class="bilhete max-w-[560px] -rotate-[0.8deg] px-7 pt-8 pb-7">
                <span class="fita" style="width: 100px; margin-left: -50px;" aria-hidden="true"></span>
                @if ($ehDono && ! $mostrarPersonagens)
                    <p>Seus personagens estão ocultos para os outros jogadores. Dá para mudar isso em Editar perfil.</p>
                @elseif ($ehDono)
                    <p>Seus personagens aparecem aqui para os outros jogadores, em modo leitura.</p>
                @else
                    <p>{{ $usuario->nome }} ainda não tem personagens públicos.</p>
                @endif
            </div>
        </section>
    @endif
@endsection
