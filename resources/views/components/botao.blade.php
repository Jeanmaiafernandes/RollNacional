@props([
    'variante' => 'primario',
    'tamanho' => 'md',
    'href' => null,
    'tipo' => 'button',
    'icone' => null,
    'iconeDepois' => null,
    'bloco' => false,
])

@php
    $classes = collect([
        'inline-flex items-center justify-center gap-2 rounded-[10px] font-semibold no-underline transition-colors cursor-pointer disabled:cursor-not-allowed disabled:opacity-60',
        match ($tamanho) {
            'sm' => 'h-10 px-3.5 text-sm',
            'lg' => 'h-[50px] px-5 text-base',
            default => 'h-11 px-4 text-sm',
        },
        match ($variante) {
            'secundario' => 'border border-borda-forte bg-superficie-2 text-texto hover:border-marcador hover:text-texto',
            'fantasma' => 'text-texto hover:bg-superficie-2 hover:text-texto',
            'perigo' => 'border border-perigo-forte bg-transparent text-[#ffb3b3] hover:bg-perigo-fundo hover:text-[#ffb3b3]',
            'perigo-texto' => 'bg-transparent text-perigo hover:bg-perigo-fundo hover:text-perigo',
            default => 'bg-ambar text-sobre-ambar hover:bg-ambar-claro hover:text-sobre-ambar',
        },
        $bloco ? 'w-full' : '',
    ])->filter()->implode(' ');

    $tamanhoIcone = $tamanho === 'lg' ? 'size-[18px]' : 'size-4';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>
        @if ($icone)<x-icone :nome="$icone" :class="$tamanhoIcone" stroke-width="2.2" />@endif
        {{ $slot }}
        @if ($iconeDepois)<x-icone :nome="$iconeDepois" :class="$tamanhoIcone" stroke-width="2.2" />@endif
    </a>
@else
    <button type="{{ $tipo }}" {{ $attributes->class($classes) }}>
        @if ($icone)<x-icone :nome="$icone" :class="$tamanhoIcone" stroke-width="2.2" />@endif
        {{ $slot }}
        @if ($iconeDepois)<x-icone :nome="$iconeDepois" :class="$tamanhoIcone" stroke-width="2.2" />@endif
    </button>
@endif
