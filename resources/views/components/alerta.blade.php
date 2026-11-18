@props(['tipo' => 'info'])

@php
    [$caixa, $icone, $corIcone] = match ($tipo) {
        'erro' => ['border-tormenta-borda bg-erro-fundo text-erro-texto', 'alerta', ''],
        'sucesso' => ['border-[#2b5a3f] bg-sucesso-fundo text-sucesso-texto', 'check', ''],
        default => ['border-borda bg-fundo text-texto-2', 'info', 'text-ambar'],
    };
@endphp

<div role="{{ $tipo === 'erro' ? 'alert' : 'status' }}" {{ $attributes->class("flex items-start gap-2.5 rounded-xl border px-4 py-3 text-sm leading-normal $caixa") }}>
    <x-icone :nome="$icone" class="mt-px size-[18px] {{ $corIcone }}" />
    <div>{{ $slot }}</div>
</div>
