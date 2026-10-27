@php
    $chave = data_get($campo, 'chave');
    $rotulo = data_get($campo, 'rotulo', $chave);
    $padrao = data_get($campo, 'padrao');
    $valor = old("valores.$chave", data_get($valores, $chave, $padrao));
    $id = 'campo-' . $chave;
    $expressao = data_get($campo, 'expressao');
@endphp
@if ($expressao && ! data_get($campo, 'editavel', true))
    {{-- Campo calculado (ex.: Defesa = 10 + @{agilidade}): só mostra. --}}
    <div class="calculado">
        <span>{{ $rotulo }}</span>
        <strong>{{ $valor ?? '—' }}</strong>
        <small>calculado: {{ $expressao }}</small>
    </div>
@else
    <label for="{{ $id }}" class="campo">{{ $rotulo }}
        <div style="display: flex; gap: 8px">
            <input type="number" id="{{ $id }}" name="valores[{{ $chave }}]" value="{{ $valor }}"
                   min="{{ data_get($campo, 'minimo') }}" max="{{ data_get($campo, 'maximo') }}" class="entrada entrada--numero">
            @if ($expressao && $rolar)
                <button type="submit" form="form-rolar" name="chave" value="{{ $chave }}" class="botao--rolar" style="height: 40px; padding: 0 12px" aria-label="Rolar {{ $rotulo }}">
                    @include('parciais.icone', ['nome' => 'dado', 'tamanho' => 14])
                </button>
            @endif
        </div>
    </label>
@endif
