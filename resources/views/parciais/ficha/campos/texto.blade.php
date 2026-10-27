@php
    $chave = data_get($campo, 'chave');
    $rotulo = data_get($campo, 'rotulo', $chave);
    $padrao = data_get($campo, 'padrao');
    $valor = old("valores.$chave", data_get($valores, $chave, $padrao));
    $id = 'campo-' . $chave;
    $expressao = data_get($campo, 'expressao');
@endphp
<label for="{{ $id }}" class="campo">{{ $rotulo }}
    <input type="text" id="{{ $id }}" name="valores[{{ $chave }}]" value="{{ $valor }}" class="entrada">
</label>
