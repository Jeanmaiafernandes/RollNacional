{{--
    Ficha na mesa. Rota: fichas.exibir (GET) / fichas.atualizar (PUT).
    Espera: $ficha (com ->item, ->campanha, ->sistema, ->tipo, ->valores, ->retrato_caminho),
            $estrutura (App\Servicos\Fichas\EstruturaFicha da versão atual).
    Quem só pode ler recebe o formulário dentro de <fieldset disabled>.
    A view personagens/exibir.blade.php reaproveita as mesmas parciais para a ficha da conta.
--}}
@extends('layouts.pagina')

@section('titulo', $ficha->item->nome)

@section('conteudo')
    @php
        $somenteLeitura = ! auth()->user()->can('atualizar', $ficha);
        $campanha = $ficha->item->campanha;
    @endphp

    <header class="ficha-topo">
        <a href="{{ route('mesa.exibir', $campanha) }}" class="voltar">
            @include('parciais.icone', ['nome' => 'voltar', 'tamanho' => 14, 'espessura' => 2.5])
            {{ $campanha->nome }}
        </a>
        <span class="apagado">/</span>
        <span style="font-size: 13px; color: var(--texto-medio)">
            {{ $ficha->sistema->nome }} · {{ $ficha->tipo->rotulo() }}
            @if ($somenteLeitura) · <span class="apagado">somente leitura</span> @endif
        </span>
        <div style="flex-grow: 1"></div>
        <span class="apagado pequeno">Salva {{ $ficha->updated_at->diffForHumans() }}</span>
        @unless ($somenteLeitura)
            <button type="submit" form="form-ficha" class="botao botao--primario" style="height: 40px">Salvar ficha</button>
        @endunless
    </header>

    <div style="max-width: 1200px; margin: 0 auto; padding: 20px 32px 0">
        @include('parciais.avisos')
    </div>

    <form id="form-ficha" method="POST" action="{{ route('fichas.atualizar', $ficha) }}" class="ficha-corpo" enctype="multipart/form-data">
        @csrf @method('PUT')
        <fieldset @disabled($somenteLeitura) style="border: 0; padding: 0; margin: 0; min-width: 0; display: contents">
            @include('parciais.ficha.formulario', [
                'nome' => $ficha->item->nome,
                'retrato' => $ficha->retrato_caminho,
                'estrutura' => $estrutura,
                'valores' => $ficha->valores ?? [],
                'rolar' => Route::has('fichas.rolar') ? route('fichas.rolar', $ficha) : null,
            ])
        </fieldset>
    </form>

    @if (Route::has('fichas.rolar') && ! $somenteLeitura)
        {{-- Form separado para os botões de rolar (não aninhar forms). Os botões usam form="form-rolar" e name="chave". --}}
        <form id="form-rolar" method="POST" action="{{ route('fichas.rolar', $ficha) }}">@csrf</form>
    @endif
@endsection
