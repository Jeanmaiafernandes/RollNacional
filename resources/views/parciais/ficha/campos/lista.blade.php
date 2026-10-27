{{-- Lista de linhas (inventário, rituais…). Linhas existentes + uma em branco para adicionar; checkbox _remover apaga. --}}
@php
    $chave = data_get($campo, 'chave');
    $rotulo = data_get($campo, 'rotulo', $chave);
    $padrao = data_get($campo, 'padrao');
    $valor = old("valores.$chave", data_get($valores, $chave, $padrao));
    $id = 'campo-' . $chave;
    $expressao = data_get($campo, 'expressao');
@endphp
@php
    $subcampos = collect(data_get($campo, 'subcampos', []));
    $linhas = collect(old("valores.$chave", data_get($valores, $chave, [])))->values();
    $linhas->push([]); // linha em branco: o NormalizadorDeValores ignora se ficar vazia
@endphp
<div style="display: flex; flex-direction: column; gap: 8px">
    <div class="painel__topo">
        <span style="font-weight: 600; font-size: 13px; color: var(--texto-medio)">{{ $rotulo }}</span>
        <span class="apagado pequeno mono">{{ $linhas->count() - 1 }} {{ $linhas->count() - 1 === 1 ? 'item' : 'itens' }}</span>
    </div>
    <div class="rolagem-x">
        <table class="tabela tabela--compacta" style="min-width: 480px">
            <thead>
                <tr>
                    @foreach ($subcampos as $sub)
                        <th>{{ data_get($sub, 'rotulo', data_get($sub, 'chave')) }}</th>
                    @endforeach
                    <th class="centro" style="width: 64px">Remover</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($linhas as $i => $linha)
                    @php $nova = $loop->last; @endphp
                    <tr>
                        @foreach ($subcampos as $sub)
                            @php
                                $subChave = data_get($sub, 'chave');
                                $subTipo = data_get($sub, 'tipo') instanceof \BackedEnum ? data_get($sub, 'tipo')->value : (string) data_get($sub, 'tipo');
                                $subValor = data_get($linha, $subChave);
                                $nomeInput = "valores[$chave][$i][$subChave]";
                                $classeNova = $nova ? 'entrada--nova' : '';
                            @endphp
                            <td>
                                @if ($subTipo === 'selecao')
                                    <select name="{{ $nomeInput }}" class="selecao selecao--compacta {{ $classeNova }}" aria-label="{{ data_get($sub, 'rotulo') }} da linha {{ $i + 1 }}">
                                        <option value="">—</option>
                                        @foreach (data_get($sub, 'opcoes', []) as $opcao)
                                            <option value="{{ $opcao }}" @selected((string) $subValor === (string) $opcao)>{{ $opcao }}</option>
                                        @endforeach
                                    </select>
                                @elseif ($subTipo === 'numero')
                                    <input type="number" name="{{ $nomeInput }}" value="{{ $subValor }}" class="entrada entrada--compacta entrada--numero {{ $classeNova }}" aria-label="{{ data_get($sub, 'rotulo') }} da linha {{ $i + 1 }}">
                                @elseif ($subTipo === 'rolagem')
                                    <div style="display: flex; gap: 4px">
                                        <input type="text" name="{{ $nomeInput }}" value="{{ $subValor }}" class="entrada entrada--compacta entrada--mono {{ $classeNova }}" style="letter-spacing: 0; min-width: 0" aria-label="{{ data_get($sub, 'rotulo') }} da linha {{ $i + 1 }}">
                                        @if ($rolar && ! $nova && $subValor)
                                            <button type="submit" form="form-rolar" name="chave" value="{{ $chave }}.{{ $i }}.{{ $subChave }}" class="botao--rolar" style="height: 36px; width: 32px" aria-label="Rolar {{ data_get($linha, 'nome', 'linha ' . ($i + 1)) }}">d</button>
                                        @endif
                                    </div>
                                @else
                                    <input type="text" name="{{ $nomeInput }}" value="{{ $subValor }}" class="entrada entrada--compacta {{ $classeNova }}"
                                           placeholder="{{ $nova && $loop->first ? 'Novo item…' : '' }}" aria-label="{{ data_get($sub, 'rotulo') }} da linha {{ $i + 1 }}">
                                @endif
                            </td>
                        @endforeach
                        <td class="centro">
                            @if ($nova)
                                <span class="apagado pequeno">em branco adiciona</span>
                            @else
                                <input type="checkbox" name="valores[{{ $chave }}][{{ $i }}][_remover]" value="1" class="caixa" aria-label="Remover linha {{ $i + 1 }}">
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
