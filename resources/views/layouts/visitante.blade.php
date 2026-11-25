<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @include('layouts.partials.head')
</head>
<body class="min-h-screen">
<div class="flex min-h-screen flex-wrap border-t-[5px] border-t-vermelho">

    <aside class="relative flex flex-[1_1_560px] flex-col gap-7 overflow-hidden border-b border-linha bg-marfim px-6 py-6 md:border-r md:border-b-0 md:px-14 md:py-10 md:pl-[72px]">
        @include('layouts.partials.runas')

        <div class="flex flex-wrap items-center justify-between gap-4">
            @include('layouts.partials.marca')
        </div>

        <figure class="polaroide mx-auto mt-3 hidden w-full max-w-[420px] -rotate-[1.5deg] md:block">
            <span class="fita" style="left: 26px; margin-left: 0; width: 110px; transform: rotate(-5deg);" aria-hidden="true"></span>
            <span class="fita fita-vermelha" style="left: auto; right: 22px; margin-left: 0; width: 90px; transform: rotate(6deg);" aria-hidden="true"></span>
            <img src="@yield('imagem')" alt="" class="block aspect-[4/5] w-full object-cover object-[38%_center]">
            <figcaption><span class="text-vermelho">@yield('legenda')</span><span>Ilustração</span></figcaption>
        </figure>

        <span class="etiqueta mx-auto hidden rotate-1 text-[22px] md:inline-block">@yield('frase')</span>
    </aside>

    <main id="conteudo" class="flex flex-[1_1_480px] items-center justify-center px-6 py-14 md:px-14">
        <div class="flex w-full max-w-[460px] flex-col gap-7">
            <nav aria-label="Acesso" class="flex gap-7 border-b border-linha">
                @foreach ([['entrar', 'Entrar'], ['registrar', 'Criar conta']] as [$rota, $texto])
                    <a href="{{ route($rota) }}"
                       @if (request()->routeIs($rota)) aria-current="page" @endif
                       class="pb-3 font-rotulo text-base font-semibold uppercase tracking-[0.08em] no-underline {{ request()->routeIs($rota) ? 'text-tinta shadow-[inset_0_-3px_0_var(--color-vermelho)]' : 'text-tinta-3 hover:text-tinta' }}">{{ $texto }}</a>
                @endforeach
            </nav>

            @yield('conteudo')
        </div>
    </main>
</div>
</body>
</html>
