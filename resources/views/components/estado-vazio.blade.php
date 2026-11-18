
@props(['titulo', 'acao' => null, 'rotuloAcao' => null, 'icone' => 'ficha'])

<div {{ $attributes->class('flex flex-col items-center gap-3 rounded-2xl border border-dashed border-borda-forte bg-recuo px-6 py-12 text-center') }}>
    <span class="flex size-[52px] items-center justify-center rounded-[14px] bg-superficie-2" aria-hidden="true">
        <x-icone :nome="$icone" class="size-6 text-ambar" stroke-width="1.8" />
    </span>
    <h2 class="text-base font-semibold">{{ $titulo }}</h2>
    <p class="max-w-md text-sm text-suave">{{ $slot }}</p>
    @if ($acao)
        <x-botao :href="$acao" icone="mais" class="mt-2">{{ $rotuloAcao }}</x-botao>
    @endif
</div>
