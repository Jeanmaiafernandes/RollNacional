{{--
    Corpo da ficha montado a partir da estrutura do sistema.
    Entradas: $nome, $retrato (caminho ou null), $estrutura (EstruturaFicha), $valores (array), $rolar (url ou null).
    A estrutura é lida com data_get(), então funciona tanto com arrays quanto com objetos:
    secoes[] → {chave, titulo, campos[]} ; campo → {chave, tipo, rotulo, padrao?, minimo?, maximo?, opcoes?, subcampos?, expressao?, publico?}
    Convenção de nomes dos inputs: valores[chave]; recurso: valores[chave][atual|maximo];
    lista: valores[chave][i][subchave] + valores[chave][i][_remover] e uma linha em branco no fim para adicionar.

    Regras de layout por seção:
      - todos os campos "numero" (3 ou mais)      → grade de atributos (1 coluna da grade)
      - tem campo "lista" ou "texto_longo"        → largura toda, listas uma embaixo da outra
      - só campos curtos (texto/numero/selecao…) → painel de 1 coluna com os campos em 2 colunas
      - recursos                                  → 1 coluna
--}}
@php
    $secoes = data_get($estrutura, 'secoes', method_exists($estrutura, 'secoes') ? $estrutura->secoes() : []);
    $tipoDe = fn ($campo) => data_get($campo, 'tipo') instanceof \BackedEnum ? data_get($campo, 'tipo')->value : (string) data_get($campo, 'tipo');
@endphp

<section class="painel faixa" aria-label="Identidade" style="gap: 20px">
    <div class="retrato">
        @if ($retrato)
            <img src="{{ Route::has('fichas.retrato') ? $retrato : asset('storage/' . $retrato) }}" alt="Retrato de {{ $nome }}">
        @else
            @include('parciais.icone', ['nome' => 'imagem', 'tamanho' => 22])
            Retrato
        @endif
    </div>
    <div style="flex: 1 1 320px; display: flex; flex-direction: column; gap: 10px">
        <label class="campo">Nome
            <input type="text" name="nome" value="{{ old('nome', $nome) }}" required class="entrada entrada--grande">
        </label>
        <label class="campo campo--linha">
            <span class="botao botao--contorno botao--pequeno" style="pointer-events: none">Trocar retrato</span>
            <input type="file" name="retrato" accept="image/*" class="arquivo" aria-label="Trocar retrato">
            <span class="apagado pequeno">PNG ou JPG, até 2 MB</span>
        </label>
    </div>
</section>

<div class="grade grade--3">
    @foreach ($secoes as $secao)
        @php
            $campos = collect(data_get($secao, 'campos', []));
            $tipos = $campos->map($tipoDe);
            $ehAtributos = $tipos->isNotEmpty() && $tipos->every(fn ($t) => $t === 'numero') && $campos->count() >= 3;
            $larga = $tipos->contains('lista') || $tipos->contains('texto_longo');
            $ehRecursos = $tipos->contains('recurso');
            $curtos = ! $ehAtributos && ! $larga && ! $ehRecursos;
        @endphp
        <section class="painel {{ $larga ? 'grade__3col' : '' }}" aria-labelledby="secao-{{ data_get($secao, 'chave') }}">
            <h2 id="secao-{{ data_get($secao, 'chave') }}" class="painel__titulo painel__titulo--secao">{{ data_get($secao, 'titulo') }}</h2>

            @if ($ehAtributos)
                <div class="atributos">
                    @foreach ($campos as $campo)
                        @include('parciais.ficha.campos.atributo', ['campo' => $campo, 'valores' => $valores, 'rolar' => $rolar])
                    @endforeach
                </div>
            @elseif ($curtos)
                <div class="grade grade--2" style="gap: 12px 16px">
                    @foreach ($campos as $campo)
                        @include('parciais.ficha.campos.' . $tipoDe($campo), ['campo' => $campo, 'valores' => $valores, 'rolar' => $rolar])
                    @endforeach
                </div>
            @else
                <div style="display: flex; flex-direction: column; gap: 16px">
                    @foreach ($campos as $campo)
                        @include('parciais.ficha.campos.' . $tipoDe($campo), ['campo' => $campo, 'valores' => $valores, 'rolar' => $rolar])
                    @endforeach
                </div>
            @endif
        </section>
    @endforeach
</div>
