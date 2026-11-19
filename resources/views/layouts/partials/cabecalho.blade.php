{{-- Cabeçalho das páginas de quem está logado. Itens sem rota cadastrada ficam escondidos. --}}
@php
    $usuario = auth()->user();
    $iniciais = collect(preg_split('/\s+/', trim($usuario->nome ?? '')))
        ->filter()->take(2)->map(fn ($parte) => mb_strtoupper(mb_substr($parte, 0, 1)))->implode('');

    $menu = array_filter([
        ['inicio', 'inicio', 'Início'],
        ['sistemas.index', 'sistemas.*', 'Sistemas'],
        ['personagens.index', 'personagens.*', 'Personagens'],
    ], fn ($item) => Route::has($item[0]));

    $conta = array_filter([
        ['usuarios.show', 'Perfil público', ['usuario' => $usuario->nome_usuario]],
        ['conta.perfil', 'Editar perfil', []],
    ], fn ($item) => Route::has($item[0]));
@endphp

<header class="border-t-[5px] border-b border-t-vermelho border-b-linha bg-papel">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center gap-x-8 gap-y-3 px-6 py-3 md:px-8">
        @include('layouts.partials.marca', ['link' => route('inicio')])

        <nav aria-label="Principal" class="order-3 flex w-full flex-wrap gap-1 md:order-none md:w-auto md:flex-1">
            @foreach ($menu as [$rota, $padrao, $texto])
                <a href="{{ route($rota) }}"
                   @if (request()->routeIs($padrao)) aria-current="page" @endif
                   class="flex h-11 items-center px-3 font-rotulo text-[15px] uppercase tracking-[0.08em] no-underline {{ request()->routeIs($padrao) ? 'font-semibold text-tinta shadow-[inset_0_-3px_0_var(--color-vermelho)]' : 'font-medium text-tinta-2 hover:text-tinta' }}">
                    {{ $texto }}
                </a>
            @endforeach
        </nav>

        <div class="ml-auto flex items-center gap-3.5">
            @if (Route::has('personagens.create'))
                <a href="{{ route('personagens.create') }}" class="btn btn-pequeno">+ Nova ficha</a>
            @endif

            <details class="relative">
                <summary class="flex cursor-pointer list-none items-center gap-2 [&::-webkit-details-marker]:hidden" aria-label="Menu da conta">
                    @if ($usuario->caminho_avatar)
                        <img src="{{ asset('storage/'.$usuario->caminho_avatar) }}" alt="" class="size-10 rounded-full border-2 border-dourado object-cover">
                    @else
                        <span class="flex size-10 items-center justify-center rounded-full border-2 border-dourado bg-marfim font-rotulo text-[15px] font-semibold">{{ $iniciais }}</span>
                    @endif
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#4a3f3a" stroke-width="2.5" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
                </summary>

                <div class="absolute right-0 z-20 mt-3 w-64 border-2 border-tinta bg-papel shadow-[0_14px_28px_rgba(60,20,10,0.14)]">
                    <div class="border-b border-linha bg-marfim px-4 py-3">
                        <p class="font-semibold">{{ $usuario->nome }}</p>
                        <p class="font-rotulo text-sm tracking-[0.1em] text-dourado-texto">{{ '@'.$usuario->nome_usuario }}</p>
                    </div>
                    <nav aria-label="Conta" class="flex flex-col">
                        @foreach ($conta as [$rota, $texto, $parametros])
                            <a href="{{ route($rota, $parametros) }}" class="border-b border-linha px-4 py-2.5 text-[17px] text-tinta no-underline hover:bg-vermelho-claro hover:text-tinta">{{ $texto }}</a>
                        @endforeach
                        <form method="POST" action="{{ route('sair') }}">
                            @csrf
                            <button type="submit" class="w-full cursor-pointer px-4 py-2.5 text-left font-rotulo text-sm font-semibold uppercase tracking-[0.12em] text-vermelho hover:bg-vermelho-claro">Sair</button>
                        </form>
                    </nav>
                </div>
            </details>
        </div>
    </div>
</header>
