{{--
    Layout de quem está logado.

    @extends('layouts.app')
    @section('titulo', 'Início')
    @section('trilha', 'Início')            ← opcional, aparece na faixa
    @section('capitulo', 'Painel')          ← opcional, aparece na faixa
    @section('faixa') ... @endsection       ← opcional: faixa marfim com o título da página
    @section('conteudo') ... @endsection

    Telas antigas que ainda usam <x-layouts::app> continuam funcionando ($slot)
    até serem convertidas.
--}}
    <!DOCTYPE html>
<html lang="pt-BR">
<head>
    @include('layouts.partials.head')
</head>
<body class="flex min-h-screen flex-col">
<a href="#conteudo" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:bg-papel focus:px-4 focus:py-2">Pular para o conteúdo</a>

@include('layouts.partials.cabecalho')

@hasSection('faixa')
    <section class="border-b border-linha bg-marfim">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-6 pt-7 pb-8 md:px-8">
            <div class="flex flex-wrap justify-between gap-3">
                <nav aria-label="Trilha" class="text-[15px] italic text-tinta-3">@yield('trilha')</nav>
                @hasSection('capitulo')
                    <span class="sobrelinha text-xs tracking-[0.24em]">Capítulo: @yield('capitulo')</span>
                @endif
            </div>
            @yield('faixa')
        </div>
    </section>
@endif

<main id="conteudo" class="mx-auto box-border flex w-full max-w-7xl flex-col gap-8 px-6 pt-10 pb-20 md:px-8">
    @include('layouts.partials.avisos')

    @isset($slot)
        {{ $slot }}
    @else
        @yield('conteudo')
    @endisset
</main>

@include('layouts.partials.rodape')
</body>
</html>
