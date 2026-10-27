{{-- Variante compacta de "numero" usada quando a seção inteira é de atributos. --}}
@php
    $chave = data_get($campo, 'chave');
    $rotulo = data_get($campo, 'rotulo', $chave);
    $padrao = data_get($campo, 'padrao');
    $valor = old("valores.$chave", data_get($valores, $chave, $padrao));
    $id = 'campo-' . $chave;
    $expressao = data_get($campo, 'expressao');
@endphp
<div class="atributo">
    <label for="{{ $id }}">{{ $rotulo }}</label>
    <input type="number" id="{{ $id }}" name="valores[{{ $chave }}]" value="{{ $valor }}"
           min="{{ data_get($campo, 'minimo') }}" max="{{ data_get($campo, 'maximo') }}" class="entrada">
    @if ($expressao && $rolar)
        <button type="submit" form="form-rolar" name="chave" value="{{ $chave }}" class="botao--rolar botao--largo" aria-label="Rolar {{ $rotulo }}">
            {{ max(1, (int) $valor) }}d20
        </button>
    @endif
</div>
