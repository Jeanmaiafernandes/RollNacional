<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo') — RollNacional</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
</head>
{{-- Fundo em grade, como um mapa de batalha --}}
<body class="min-h-screen bg-fundo bg-[linear-gradient(to_right,#1b1e23_1px,transparent_1px),linear-gradient(to_bottom,#1b1e23_1px,transparent_1px)] bg-size-[44px_44px] font-sans text-texto">
<div class="mx-auto grid min-h-screen max-w-6xl items-center gap-8 px-6 py-10 lg:grid-cols-[1fr_440px] lg:gap-20">

    {{-- Apresentação --}}
    <section class="flex flex-col gap-8">
        <a href="{{ route('entrar') }}" class="flex items-center gap-3 text-texto no-underline hover:text-texto">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" class="size-9 text-ambar" aria-hidden="true">
                <polygon points="12,2 21,7 21,17 12,22 3,17 3,7"/>
                <polygon points="12,6.5 17,15.5 7,15.5"/>
                <path d="M12 2v4.5M21 7l-4 8.5M3 7l4 8.5M12 22l-5-6.5M12 22l5-6.5"/>
            </svg>
            <span class="font-titulo text-2xl font-extrabold tracking-tight">Roll<span class="text-ambar">Nacional</span></span>
        </a>

        <div class="hidden flex-col gap-8 lg:flex">
            <h1 class="max-w-md font-titulo text-5xl font-extrabold leading-[1.05] tracking-tight">
                Monte a ficha.<br>
                <span class="text-ambar">Role os dados.</span>
            </h1>

            <p class="max-w-md text-[17px] leading-relaxed text-suave">
                Mesa virtual pensada para RPG nacional: fichas com cálculo automático,
                compêndio de regras e, em breve, campanhas com a sua mesa.
            </p>

            {{-- Sumário dos sistemas, no estilo de índice de livro --}}
            <div class="max-w-md">
                <p class="mb-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-suave">Sistemas na mesa</p>
                <ol class="flex flex-col border-t border-borda">
                    <li class="flex items-baseline gap-3 border-b border-borda py-3">
                        <span class="font-titulo text-sm font-bold text-tormenta">01</span>
                        <span class="font-medium">Tormenta20</span>
                        <span class="flex-1 border-b border-dotted border-marcador" aria-hidden="true"></span>
                        <span class="text-xs uppercase tracking-wider text-suave">Nacional</span>
                    </li>
                    <li class="flex items-baseline gap-3 border-b border-borda py-3">
                        <span class="font-titulo text-sm font-bold text-dnd">02</span>
                        <span class="font-medium">D&amp;D 5e</span>
                        <span class="flex-1 border-b border-dotted border-marcador" aria-hidden="true"></span>
                        <span class="text-xs uppercase tracking-wider text-suave">SRD</span>
                    </li>
                </ol>
            </div>
        </div>
    </section>

    {{-- Folha do formulário: cantos marcados como uma ficha impressa --}}
    <main class="relative border border-borda-forte bg-superficie">
        <span class="absolute -left-px -top-px size-4 border-l-2 border-t-2 border-ambar" aria-hidden="true"></span>
        <span class="absolute -right-px -top-px size-4 border-r-2 border-t-2 border-ambar" aria-hidden="true"></span>
        <span class="absolute -bottom-px -left-px size-4 border-b-2 border-l-2 border-ambar" aria-hidden="true"></span>
        <span class="absolute -bottom-px -right-px size-4 border-b-2 border-r-2 border-ambar" aria-hidden="true"></span>

        {{-- Abas entre entrar e criar conta --}}
        <nav aria-label="Acesso" class="grid grid-cols-2 border-b border-borda-forte">
            <a href="{{ route('entrar') }}" @if (request()->routeIs('entrar')) aria-current="page" @endif
                @class([
                    'flex h-12 items-center justify-center text-xs font-semibold uppercase tracking-[0.14em] no-underline',
                    'bg-superficie text-ambar-claro shadow-[inset_0_-2px_0_var(--color-ambar)] hover:text-ambar-claro' => request()->routeIs('entrar'),
                    'bg-recuo text-suave hover:text-texto' => ! request()->routeIs('entrar'),
                ])>Entrar</a>
            <a href="{{ route('cadastrar') }}" @if (request()->routeIs('cadastrar')) aria-current="page" @endif
                @class([
                    'flex h-12 items-center justify-center border-l border-borda-forte text-xs font-semibold uppercase tracking-[0.14em] no-underline',
                    'bg-superficie text-ambar-claro shadow-[inset_0_-2px_0_var(--color-ambar)] hover:text-ambar-claro' => request()->routeIs('registrar'),
                    'bg-recuo text-suave hover:text-texto' => ! request()->routeIs('registrar'),
                ])>Criar conta</a>
        </nav>

        <div class="p-6 sm:p-8">
            @yield('conteudo')
        </div>
    </main>
</div>
</body>
</html>
