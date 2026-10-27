{{--
    Cartão de rolagem. $entrada = App\Models\Rolagem (->usuario, ->ficha nulo, ->rotulo, ->expressao, ->total, ->detalhes, ->secreta).
    detalhes: ['partes' => [['dados' => [17, 19, 4], 'mantidos' => [19]], ...], 'modificador' => 10] — adapte ao seu ResultadoRolagem.
--}}
@php
    $ehMestre = $entrada->usuario_id === $campanha->mestre_id;
    $quem = $entrada->ficha?->item->nome ?? ($ehMestre ? 'Mestre' : $entrada->usuario->nome);
    $partes = collect(data_get($entrada->detalhes, 'partes', []));
@endphp
<div class="rolagem {{ $ehMestre ? '' : 'rolagem--jogador' }} {{ $entrada->secreta ? 'rolagem--secreta' : '' }}">
    <div class="fala__quem">
        <strong class="{{ $ehMestre && ! $entrada->ficha ? 'mestre' : '' }}">{{ $quem }}</strong>
        <span>
            @if ($entrada->secreta) rolagem secreta · só você vê
            @else {{ $entrada->rotulo ?: 'rolagem' }} · {{ $entrada->created_at->format('H:i') }}
            @endif
        </span>
    </div>
    <div class="rolagem__total">
        <strong>{{ $entrada->total }}</strong>
        <span>
            {{ $entrada->expressao }}
            @if ($partes->isNotEmpty())
                →
                @foreach ($partes as $parte)
                    @php $dados = collect(data_get($parte, 'dados', [])); $mantidos = collect(data_get($parte, 'mantidos', $dados)); @endphp
                    [{!! $dados->map(fn ($d) => $mantidos->contains($d) ? "<b>$d</b>" : $d)->implode(', ') !!}]
                @endforeach
                @if ($mod = data_get($entrada->detalhes, 'modificador')) {{ $mod > 0 ? "+$mod" : $mod }} @endif
            @endif
        </span>
    </div>
</div>
