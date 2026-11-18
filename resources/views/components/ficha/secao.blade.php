@props(['titulo', 'nota' => null, 'acao' => null])

@php $idTitulo = 'secao-'.Str::slug($titulo); @endphp

<section aria-labelledby="{{ $idTitulo }}" {{ $attributes->class('rn-cartao flex flex-col gap-3.5 p-[22px]') }}>
    <div class="flex flex-wrap items-baseline justify-between gap-2">
        <h2 id="{{ $idTitulo }}" class="text-lg font-semibold">{{ $titulo }}</h2>
        @if ($nota)
            <span class="text-[13px] text-suave">{{ $nota }}</span>
        @endif
        {{ $acao }}
    </div>

    {{ $slot }}
</section>
