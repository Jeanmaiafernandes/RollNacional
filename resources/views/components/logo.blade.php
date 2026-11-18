@props(['tamanho' => 'md', 'href' => null])

@php
    $destino = $href ?? (auth()->check() ? route('painel') : route('entrar'));
@endphp

<a href="{{ $destino }}" aria-label="RollNacional, ir para o início" {{ $attributes->class('flex items-center gap-2.5 text-texto no-underline hover:text-texto') }}>
    <x-icone nome="d20" :class="$tamanho === 'lg' ? 'size-8 text-ambar' : 'size-7 text-ambar'" stroke-width="1.6" />
    <span class="font-titulo font-extrabold tracking-tight {{ $tamanho === 'lg' ? 'text-[22px]' : 'text-xl' }}">Roll<span class="text-ambar">Nacional</span></span>
</a>
