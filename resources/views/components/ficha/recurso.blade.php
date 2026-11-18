{{--
    Recurso com valor atual e máximo e barra de progresso (PV, PM...).

    <x-ficha.recurso rotulo="PV" :atual="48" :maximo="55" />
    <x-ficha.recurso rotulo="PM" :atual="12" :maximo="15" cor="azul" />

    Sem "maximo", mostra só o valor (Defesa, Deslocamento...).
--}}
@props(['rotulo', 'atual', 'maximo' => null, 'cor' => 'verde'])

@php
    $porcentagem = $maximo ? max(0, min(100, round($atual / $maximo * 100))) : null;
@endphp

<div class="flex flex-col gap-1.5 rounded-xl border border-borda bg-recuo p-3">
    <span class="text-xs font-semibold text-suave">{{ $rotulo }}</span>
    <span class="font-titulo text-[26px] font-extrabold leading-none">
        {{ $atual }}@if ($maximo)<span class="text-[15px] font-semibold text-suave"> / {{ $maximo }}</span>@endif
    </span>
    @if ($maximo)
        <span class="h-1.5 overflow-hidden rounded-full bg-[#2a2e35]" role="meter" aria-valuemin="0" aria-valuemax="{{ $maximo }}" aria-valuenow="{{ $atual }}" aria-label="{{ $rotulo }}">
            <span @class(['block h-full', 'bg-dnd' => $cor === 'azul', 'bg-sucesso' => $cor !== 'azul']) style="width: {{ $porcentagem }}%"></span>
        </span>
    @endif
</div>
