{{-- Campo do tipo rolagem: expressão de dados editável (ex.: 2d6+1) com botão de rolar. --}}
@php
    $chave = data_get($campo, 'chave');
    $rotulo = data_get($campo, 'rotulo', $chave);
    $padrao = data_get($campo, 'padrao');
    $valor = old("valores.$chave", data_get($valores, $chave, $padrao));
    $id = 'campo-' . $chave;
    $expressao = data_get($campo, 'expressao');
@endphp
<div class="lista-ficha__item" style="border: 0; padding: 0">
    <label for="{{ $id }}" class="nome">{{ $rotulo }}</label>
    <input type="text" id="{{ $id }}" name="valores[{{ $chave }}]" value="{{ $valor }}" class="entrada entrada--mono entrada--compacta" style="width: 110px; letter-spacing: 0">
    @if ($rolar)
        <button type="submit" form="form-rolar" name="chave" value="{{ $chave }}" class="botao--rolar" style="width: 36px" aria-label="Rolar {{ $rotulo }}">
            @include('parciais.icone', ['nome' => 'dado', 'tamanho' => 14])
        </button>
    @endif
</div>
