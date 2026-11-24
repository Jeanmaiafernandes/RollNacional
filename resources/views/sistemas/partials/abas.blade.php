{{-- Abas do sistema: Visão geral, Compêndio e Modelo de ficha. Abas sem rota ficam escondidas. --}}
@php
    $abas = array_filter([
        ['sistemas.show', 'Visão geral'],
        ['sistemas.compendio', 'Compêndio'],
        ['sistemas.modelo', 'Modelo de ficha'],
    ], fn ($aba) => Route::has($aba[0]));
@endphp

@if (count($abas) > 1)
    <nav aria-label="Seções do sistema" class="-mb-8 flex flex-wrap gap-7">
        @foreach ($abas as [$rota, $texto])
            <a href="{{ route($rota, $sistema->slug) }}"
               @if (request()->routeIs($rota)) aria-current="page" @endif
               class="pb-3 font-rotulo text-[15px] font-semibold uppercase tracking-[0.08em] no-underline {{ request()->routeIs($rota) ? 'text-tinta shadow-[inset_0_-3px_0_var(--color-vermelho)]' : 'text-tinta-3 hover:text-tinta' }}">{{ $texto }}</a>
        @endforeach
    </nav>
@endif
