@php
    $chave = data_get($campo, 'chave');
    $rotulo = data_get($campo, 'rotulo', $chave);
    $padrao = data_get($campo, 'padrao');
    $valor = old("valores.$chave", data_get($valores, $chave, $padrao));
    $id = 'campo-' . $chave;
    $expressao = data_get($campo, 'expressao');
@endphp
<label for="{{ $id }}" class="campo">{{ $rotulo }}
    <select id="{{ $id }}" name="valores[{{ $chave }}]" class="selecao">
        <option value="">—</option>
        @foreach (data_get($campo, 'opcoes', []) as $opcao)
            @php $v = is_array($opcao) ? ($opcao['valor'] ?? $opcao['chave'] ?? '') : $opcao; $r = is_array($opcao) ? ($opcao['rotulo'] ?? $v) : $opcao; @endphp
            <option value="{{ $v }}" @selected((string) $valor === (string) $v)>{{ $r }}</option>
        @endforeach
    </select>
</label>
