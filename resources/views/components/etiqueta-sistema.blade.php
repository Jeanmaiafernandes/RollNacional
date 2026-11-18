
@props(['cor' => 'neutra', 'estilo' => 'etiqueta'])

@php
    // Classes completas (o Tailwind só gera o que aparece literalmente no código).
    $etiqueta = match ($cor) {
        'tormenta' => 'bg-tormenta-fundo text-tormenta-texto font-semibold',
        'dnd' => 'bg-dnd-fundo text-dnd-texto font-semibold',
        'ambar' => 'bg-ambar-fundo text-ambar-claro font-semibold',
        'sucesso' => 'bg-sucesso-fundo text-sucesso-texto font-semibold',
        default => 'bg-superficie-2 text-texto-2 font-medium',
    };
    $ponto = match ($cor) {
        'tormenta' => 'bg-tormenta',
        'dnd' => 'bg-dnd',
        'ambar' => 'bg-ambar',
        'sucesso' => 'bg-sucesso',
        default => 'bg-marcador',
    };
@endphp

@if ($estilo === 'pilula')
    <span {{ $attributes->class('inline-flex items-center gap-2 rounded-full border border-borda bg-superficie px-3 py-1.5 text-sm font-medium') }}>
        <span class="size-2 rounded-full {{ $ponto }}" aria-hidden="true"></span>
        {{ $slot }}
    </span>
@else
    <span {{ $attributes->class("inline-flex items-center rounded-full px-2.5 py-1 text-xs $etiqueta") }}>{{ $slot }}</span>
@endif
