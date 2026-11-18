@php
    $usuario = auth()->user();

    $iniciais = collect(preg_split('/\s+/', trim($usuario->nome)))
        ->filter()
        ->map(fn ($parte) => mb_strtoupper(mb_substr($parte, 0, 1)))
        ->pipe(fn ($letras) => $letras->first().($letras->count() > 1 ? $letras->last() : ''));

    // Itens do menu: [rota, padrão para marcar ativo, texto, desenho do ícone]
    // Só aparecem os itens cuja rota já existe no projeto.
    $itens = collect([
        ['inicio', 'inicio', 'Início', '<path d="M3 10.5l9-6 9 6"/><path d="M5 9.5V19h14V9.5"/><path d="M9.5 19v-5h5v5"/>'],
        ['sistemas.index', 'sistemas.*', 'Sistemas', '<path d="M4 5.5A1.5 1.5 0 0 1 5.5 4H19v14H5.5A1.5 1.5 0 0 0 4 19.5z"/><path d="M4 19.5A1.5 1.5 0 0 0 5.5 21H19v-3"/><path d="M8 8h7"/>'],
        ['personagens.index', 'personagens.*', 'Personagens', '<rect x="5" y="3.5" width="14" height="17" rx="2"/><path d="M9 8h6M9 12h6M9 16h3"/>'],
    ])->filter(fn ($item) => Route::has($item[0]));

    $urlConta = Route::has('conta.perfil') ? route('conta.perfil') : url('/conta');
@endphp

<header class="sticky top-0 z-30 border-b border-borda bg-fundo-profundo/95 backdrop-blur">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center gap-x-6 gap-y-2 px-6 py-3">

        {{-- Marca --}}
        <a href="{{ route('inicio') }}" class="flex items-center gap-2.5 text-texto no-underline hover:text-texto">
            <span class="flex size-10 items-center justify-center rounded-xl border border-ambar-borda bg-ambar-fundo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" class="size-6 text-ambar" aria-hidden="true">
                    <polygon points="12,2 21,7 21,17 12,22 3,17 3,7"/>
                    <polygon points="12,6.5 17,15.5 7,15.5"/>
                    <path d="M12 2v4.5M21 7l-4 8.5M3 7l4 8.5M12 22l-5-6.5M12 22l5-6.5"/>
                </svg>
            </span>
            <span class="flex flex-col leading-none">
                <span class="font-titulo text-lg font-extrabold tracking-tight">Roll<span class="text-ambar">Nacional</span></span>
                <span class="mt-1 text-[11px] font-medium uppercase tracking-[0.14em] text-suave">Mesa virtual</span>
            </span>
        </a>

        {{-- Menu principal --}}
        <nav aria-label="Principal" class="order-last flex w-full gap-1 overflow-x-auto border-t border-borda pt-2 md:order-none md:w-auto md:flex-1 md:border-0 md:pt-0">
            @foreach ($itens as [$rota, $padrao, $texto, $icone])
                @php $ativo = request()->routeIs($padrao); @endphp
                <a href="{{ route($rota) }}" @if ($ativo) aria-current="page" @endif
                    @class([
                        'flex h-10 shrink-0 items-center gap-2 rounded-lg border px-3 text-sm no-underline',
                        'border-ambar-borda bg-ambar-fundo font-semibold text-ambar-claro hover:text-ambar-claro' => $ativo,
                        'border-transparent font-medium text-texto-2 hover:bg-superficie hover:text-texto' => ! $ativo,
                    ])>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="size-4" aria-hidden="true">{!! $icone !!}</svg>
                    {{ $texto }}
                </a>
            @endforeach
        </nav>

        {{-- Ações e conta --}}
        <div class="ml-auto flex items-center gap-3">
            @if (Route::has('personagens.create'))
                <a href="{{ route('personagens.create') }}" class="hidden h-10 items-center gap-2 rounded-lg bg-ambar px-4 text-sm font-semibold text-sobre-ambar no-underline hover:bg-ambar-claro hover:text-sobre-ambar sm:flex">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" class="size-4" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                    Nova ficha
                </a>
            @endif

            {{-- Menu da conta: <details> abre e fecha sem JavaScript --}}
            <details class="group relative">
                <summary class="flex h-10 cursor-pointer list-none items-center gap-2.5 rounded-full border border-borda bg-superficie py-1 pl-1 pr-3 hover:border-borda-forte [&::-webkit-details-marker]:hidden">
                    <span class="flex size-8 items-center justify-center rounded-full bg-avatar font-titulo text-xs font-extrabold text-ambar-claro" aria-hidden="true">{{ $iniciais }}</span>
                    <span class="hidden max-w-[140px] truncate text-sm font-medium sm:block">{{ $usuario->nome }}</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="size-3.5 text-suave transition-transform group-open:rotate-180" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
                    <span class="sr-only">Menu da conta</span>
                </summary>

                <div class="absolute right-0 top-[calc(100%+8px)] w-64 rounded-xl border border-borda bg-superficie p-1.5 shadow-[0_18px_40px_rgba(0,0,0,0.45)]">
                    <div class="mb-1 border-b border-borda px-3 pb-3 pt-2">
                        <p class="truncate text-sm font-semibold">{{ $usuario->nome }}</p>
                        <p class="truncate text-xs text-suave">{{ $usuario->email }}</p>
                    </div>

                    <a href="{{ $urlConta }}" class="flex h-10 items-center gap-2.5 rounded-lg px-3 text-sm text-texto no-underline hover:bg-superficie-2 hover:text-texto">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" class="size-4 text-suave" aria-hidden="true"><circle cx="12" cy="8.5" r="3.5"/><path d="M5 19.5c1.2-3.3 3.8-5 7-5s5.8 1.7 7 5"/></svg>
                        Minha conta
                    </a>

                    <form method="POST" action="{{ route('sair') }}">
                        @csrf
                        <button type="submit" class="flex h-10 w-full cursor-pointer items-center gap-2.5 rounded-lg px-3 text-left text-sm text-perigo hover:bg-superficie-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="size-4" aria-hidden="true"><path d="M14 4h4a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-4"/><path d="M10 16l-4-4 4-4M6 12h10"/></svg>
                            Sair
                        </button>
                    </form>
                </div>
            </details>
        </div>
    </div>
</header>
