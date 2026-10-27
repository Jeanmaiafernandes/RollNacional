{{-- Uma mensagem do chat. $entrada = App\Models\Mensagem (->usuario, ->ficha nulo, ->texto, ->created_at). --}}
@php
    $ehMestre = $entrada->usuario_id === $campanha->mestre_id;
    $quem = $entrada->ficha?->item->nome ?? ($ehMestre ? 'Mestre' : $entrada->usuario->nome);
@endphp
<div class="fala">
    <div class="fala__quem">
        <strong class="{{ $ehMestre && ! $entrada->ficha ? 'mestre' : '' }}">{{ $quem }}</strong>
        <span>@if ($entrada->ficha) {{ $entrada->usuario->nome }} · @endif{{ $entrada->created_at->format('H:i') }}</span>
    </div>
    <p>{{ $entrada->texto }}</p>
</div>
