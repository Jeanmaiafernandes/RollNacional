@extends('layouts.publico')

@section('titulo', 'Mesa virtual para o RPG nacional')

@section('conteudo')
    {{-- Abertura: texto à esquerda, banner animado à direita --}}
    <section>
        <div class="mx-auto flex max-w-7xl flex-wrap items-center gap-x-14 gap-y-10 px-6 pt-14 pb-22 md:px-8">
            <div class="flex flex-[1_1_460px] flex-col items-start gap-6">
                <h1 class="font-rotulo text-7xl leading-[0.98] tracking-normal md:text-8xl">
                    <span class="rn-linha block text-vermelho" style="animation-delay: .1s">Roll</span>
                    <span class="rn-linha block text-vermelho" style="animation-delay: .2s">Nacional</span>
                    <span class="rn-linha block" style="animation-delay: .3s">sua mesa,</span>
                    <span class="rn-linha block" style="animation-delay: .4s">seu sistema.</span>
                </h1>

                <p class="rn-linha max-w-[520px] text-xl leading-relaxed text-tinta-2" style="animation-delay: .5s">
                    Fichas que calculam sozinhas, compêndio de regras à mão e espaço para os sistemas que os outros sites esquecem.
                </p>

                <div class="rn-linha flex flex-wrap gap-3.5" style="animation-delay: .6s">
                    <a href="{{ route('registrar') }}" class="btn h-[54px] text-[17px]">Criar conta grátis</a>
                    <a href="#sistemas" class="btn-sec h-[54px] text-[17px]">Ver sistemas</a>
                </div>
            </div>

            <div class="mx-auto w-full max-w-[620px] flex-[1_1_480px]">
                @include('publico.partials.banner')
            </div>
        </div>
    </section>

    {{-- Sistemas --}}
    <section id="sistemas" class="relative border-t border-linha bg-marfim">
        @include('layouts.partials.runas', ['lado' => 'right-5', 'cor' => '#a8191f'])

        <div class="mx-auto flex max-w-7xl flex-col gap-10 px-6 py-18 md:px-8">
            <div class="flex flex-wrap items-end justify-between gap-5">
                <h2 class="barras text-4xl md:text-5xl">Sistemas na mesa</h2>
                <p class="max-w-[420px] text-lg leading-relaxed text-tinta-2">Cada sistema tem sua ficha, seu compêndio e suas regras de rolagem. Os próximos entram conforme a comunidade pedir.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-[1fr_1fr_minmax(240px,0.9fr)]">
                <article class="flex flex-col border-2 border-tinta bg-papel" style="box-shadow: inset 0 10px 0 var(--color-tormenta)">
                    <img src="{{ asset('img/sistemas/capa-tormenta20.webp') }}" alt="Capa de Tormenta20 com o grupo de heróis do livro básico"
                         class="mt-2.5 block aspect-[3/2] w-full border-b-2 border-tinta object-cover object-top">
                    <div class="flex flex-1 flex-col gap-2.5 p-5">
                        <h3 class="text-3xl">Tormenta20</h3>
                        <p class="text-[15px] italic text-dourado-texto">Jambô Editora</p>
                        <p class="text-[17px] leading-relaxed text-tinta-2">O maior RPG brasileiro. Ficha com atributos, perícias e magias calculados a cada nível.</p>
                    </div>
                </article>

                <article class="flex flex-col border-2 border-tinta bg-papel" style="box-shadow: inset 0 10px 0 var(--color-dnd)">
                    <img src="{{ asset('img/sistemas/capa-dnd5e.webp') }}" alt="Arte de D&amp;D 5e com aventureiros e dragões"
                         class="mt-2.5 block aspect-[3/2] w-full border-b-2 border-tinta object-cover">
                    <div class="flex flex-1 flex-col gap-2.5 p-5">
                        <h3 class="text-3xl">D&amp;D 5e</h3>
                        <p class="text-[15px] italic text-dourado-texto">Wizards of the Coast</p>
                        <p class="text-[17px] leading-relaxed text-tinta-2">O clássico de fantasia, com ficha completa, espaços de magia e proficiências.</p>
                    </div>
                </article>

                <div class="flex flex-col gap-7 pt-3.5">
                    <div class="bilhete -rotate-[1.5deg]">
                        <span class="fita" aria-hidden="true"></span>
                        <p class="rotulo mb-1.5 text-xs text-vermelho">Em breve</p>
                        <p>O próximo sistema nacional pode ser o seu favorito.</p>
                    </div>
                    <div class="bilhete rotate-[1.5deg]">
                        <span class="fita fita-vermelha" aria-hidden="true"></span>
                        <p class="rotulo mb-1.5 text-xs text-vermelho">Sugestões</p>
                        <p>Conte qual sistema você quer ver aqui quando criar sua conta.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Como funciona --}}
    <section id="como-funciona" class="bg-vermelho-faixa text-[#fbf3e6]">
        <div class="mx-auto flex max-w-7xl flex-col gap-11 px-6 pt-20 pb-24 md:px-8">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <h2 class="text-5xl md:text-6xl">Como funciona</h2>
                <p class="max-w-[460px] text-lg leading-relaxed text-[#f3d9cf]">Da conta nova à primeira rolagem, sem planilha e sem PDF aberto do lado.</p>
            </div>

            <ol class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['Crie a conta', 'Nome, e-mail e senha. Nada além disso.', '-1.5deg'],
                    ['Escolha o sistema', 'Tormenta20 ou D&D 5e, por enquanto.', '1deg'],
                    ['Monte a ficha', 'A ficha faz as contas enquanto você decide.', '-1deg'],
                    ['Leve para a mesa', 'A mesa virtual chega na próxima etapa.', '1.5deg'],
                ] as [$titulo, $texto, $giro])
                    <li class="relative flex flex-col gap-2.5 bg-[#fffdf8] px-5 pt-7 pb-6 text-tinta shadow-[0_10px_20px_rgba(40,5,5,0.3)]" style="transform: rotate({{ $giro }})">
                        <span class="fita" style="background: rgba(200,150,46,0.6)" aria-hidden="true"></span>
                        <span class="text-[22px] font-bold uppercase tracking-[0.04em]">{{ $titulo }}</span>
                        <span class="text-[17px] leading-relaxed text-tinta-2">{{ $texto }}</span>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- Compêndio --}}
    <section id="compendio">
        <div class="mx-auto flex max-w-7xl flex-wrap gap-14 px-6 pt-20 pb-24 md:px-8">
            <div class="flex flex-[1_1_480px] flex-col items-start gap-5">
                <span class="sobrelinha text-[13px] tracking-[0.24em]">Regras à mão</span>
                <h2 class="text-6xl tracking-[0.14em] md:text-[88px]">Compêndio</h2>
                <p class="text-xl leading-relaxed text-tinta-2">Classes, raças, magias e condições organizadas como um livro: sumário, índice e páginas que você consulta no meio da sessão sem perder a cena.</p>
                <p class="text-lg leading-relaxed text-tinta-3">E cada entrada pode ir direto para a ficha com um clique.</p>
                <a href="{{ route('entrar') }}" class="btn mt-1.5">Entrar para abrir</a>
            </div>

            <nav aria-label="Sumário de exemplo" class="flex-[1_1_380px] self-center border border-t-4 border-linha border-t-dourado bg-marfim p-8">
                <p class="sobrelinha mb-3.5 text-[13px] tracking-[0.24em]">Sumário · Tormenta20</p>
                <ol class="flex flex-col">
                    @foreach ([
                        ['Raças', 'quem você é'], ['Classes', 'o que você faz'], ['Origens', 'de onde veio'], ['Poderes', 'o que aprende'],
                        ['Magias', 'o que conjura'], ['Equipamentos', 'o que carrega'], ['Condições', 'o que sofre'],
                    ] as [$capitulo, $nota])
                        <li class="flex items-baseline gap-3 border-b border-linha py-2.5">
                            <span class="text-[19px] font-medium">{{ $capitulo }}</span>
                            <span class="pontilhado" aria-hidden="true"></span>
                            <span class="text-[15px] italic text-dourado-texto">{{ $nota }}</span>
                        </li>
                    @endforeach
                </ol>
            </nav>
        </div>
    </section>

    {{-- Chamada final --}}
    <section class="border-t border-linha">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center gap-x-16 gap-y-12 px-6 pt-22 pb-24 md:px-8">
            <figure class="polaroide flex-[1_1_460px] -rotate-[1.5deg]">
                <span class="fita" style="left: 36px; margin-left: 0; width: 120px; transform: rotate(-5deg);" aria-hidden="true"></span>
                <span class="fita fita-vermelha" style="left: auto; right: 36px; margin-left: 0; width: 100px; transform: rotate(4deg);" aria-hidden="true"></span>
                <img src="{{ asset('img/site/dragao.webp') }}" alt="Aventureiro com tocha diante de um dragão vermelho dormindo sobre moedas de ouro" loading="lazy" class="block h-auto w-full">
                <figcaption><span class="text-vermelho">O tesouro espera</span><span>Ilustração</span></figcaption>
            </figure>

            <div class="flex flex-[1_1_380px] flex-col items-start gap-5">
                <h2 class="barras text-5xl md:text-[56px]">Pronto para a primeira sessão?</h2>
                <p class="text-xl leading-relaxed text-tinta-2">Crie a conta, escolha o sistema e monte a ficha. O dragão pode esperar mais um pouco.</p>
                <a href="{{ route('registrar') }}" class="btn h-[54px] text-[17px]">Criar conta grátis</a>
            </div>
        </div>
    </section>
@endsection
