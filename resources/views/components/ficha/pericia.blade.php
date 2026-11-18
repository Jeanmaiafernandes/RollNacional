@props(['nome', 'total', 'atributo' => null, 'treinada' => false, 'destacada' => false])

<li @class([
    'flex items-center gap-2.5',
    'min-h-10 border-b border-linha' => ! $destacada,
    'min-h-11 rounded-[10px] bg-recuo px-3' => $destacada,
])>
    @if ($treinada)
        <span class="size-2.5 shrink-0 rounded-full bg-ambar" title="Treinada"></span>
        <span class="sr-only">(treinada)</span>
    @else
        <span class="box-border size-2.5 shrink-0 rounded-full border-[1.5px] border-marcador" title="Não treinada"></span>
    @endif
    <span class="flex-1 text-sm">{{ $nome }}</span>
    @if ($atributo)
        <span class="w-8 text-xs font-semibold text-suave">{{ $atributo }}</span>
    @endif
    <span class="w-9 text-right font-titulo text-base font-bold">{{ $total }}</span>
</li>
