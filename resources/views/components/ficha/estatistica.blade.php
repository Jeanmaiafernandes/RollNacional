@props(['rotulo', 'valor', 'centro' => false])

<div @class(['rounded-[10px] bg-recuo px-3.5 py-3', 'text-center' => $centro])>
    <dt class="text-xs text-suave">{{ $rotulo }}</dt>
    <dd class="mt-1 text-[15px] font-semibold">{{ $valor }}</dd>
</div>
