@props(['sigla', 'nome', 'modificador', 'valor' => null, 'cor' => 'ambar'])

<div class="rn-cartao flex flex-col items-center gap-0.5 rounded-[14px] p-4 text-center">
    <span @class([
        'text-[13px] font-bold tracking-[0.08em]',
        'text-dnd-texto' => $cor === 'dnd',
        'text-ambar-claro' => $cor !== 'dnd',
    ])>{{ $sigla }}</span>
    <span class="font-titulo text-4xl font-extrabold leading-tight">{{ $modificador }}</span>
    @if (! is_null($valor))
        <span class="mt-1 rounded-full bg-superficie-2 px-3 py-0.5 text-sm font-semibold">{{ $valor }}</span>
    @endif
    <span class="mt-1 text-[13px] text-suave">{{ $nome }}</span>
</div>
