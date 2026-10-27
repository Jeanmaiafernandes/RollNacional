@php
    $chave = data_get($campo, 'chave');
    $rotulo = data_get($campo, 'rotulo', $chave);
    $padrao = data_get($campo, 'padrao');
    $valor = old("valores.$chave", data_get($valores, $chave, $padrao));
    $id = 'campo-' . $chave;
    $expressao = data_get($campo, 'expressao');
@endphp
@php
    $atual = (int) old("valores.$chave.atual", data_get($valores, "$chave.atual", data_get($padrao, 'atual', 0)));
    $maximo = (int) old("valores.$chave.maximo", data_get($valores, "$chave.maximo", data_get($padrao, 'maximo', 0)));
    $porcento = $maximo > 0 ? max(0, min(100, round($atual / $maximo * 100))) : 0;
    $classeBarra = str_contains(mb_strtolower($rotulo), 'vida') ? 'barra--vida' : (str_contains(mb_strtolower($rotulo), 'esforço') ? 'barra--esforco' : '');
@endphp
<div class="recurso">
    <div class="recurso__linha"><strong>{{ $rotulo }}</strong><span>{{ $atual }} / {{ $maximo }}</span></div>
    <div class="barra {{ $classeBarra }}" role="progressbar" aria-label="{{ $rotulo }}" aria-valuenow="{{ $atual }}" aria-valuemin="0" aria-valuemax="{{ $maximo }}">
        <span style="width: {{ $porcento }}%"></span>
    </div>
    <div class="recurso__entradas">
        <input type="number" name="valores[{{ $chave }}][atual]" value="{{ $atual }}" aria-label="{{ $rotulo }} atual" class="entrada">
        <input type="number" name="valores[{{ $chave }}][maximo]" value="{{ $maximo }}" aria-label="{{ $rotulo }} máximo" class="entrada">
    </div>
</div>
