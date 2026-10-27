{{--
    Ficha de personagem da CONTA. Rota: personagens.exibir (GET) / personagens.atualizar (PUT) / personagens.excluir (DELETE).
    Espera: $personagem (->sistema, ->tipo, ->valores, ->retrato_caminho), $estrutura (EstruturaFicha).
    Reaproveita as mesmas parciais da ficha da mesa. Sem botão de rolar: rolagem só existe dentro de uma mesa.
--}}
@extends('layouts.pagina')

@section('titulo', $personagem->nome)

@section('conteudo')
    <header class="ficha-topo">
        <a href="{{ route('personagens.listar') }}" class="voltar">
            @include('parciais.icone', ['nome' => 'voltar', 'tamanho' => 14, 'espessura' => 2.5])
            Meus personagens
        </a>
        <span class="apagado">/</span>
        <span style="font-size: 13px; color: var(--texto-medio)">{{ $personagem->sistema->nome }} · {{ $personagem->tipo->rotulo() }}</span>
        <div style="flex-grow: 1"></div>
        <span class="apagado pequeno">Salvo {{ $personagem->updated_at->diffForHumans() }}</span>
        @if (Route::has('personagens.importar'))
            <a href="{{ route('personagens.importar', $personagem) }}" class="botao botao--contorno" style="height: 40px">Importar para uma mesa</a>
        @endif
        <button type="submit" form="form-ficha" class="botao botao--primario" style="height: 40px">Salvar ficha</button>
    </header>

    <div style="max-width: 1200px; margin: 0 auto; padding: 20px 32px 0">
        @include('parciais.avisos')
    </div>

    <form id="form-ficha" method="POST" action="{{ route('personagens.atualizar', $personagem) }}" class="ficha-corpo" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('parciais.ficha.formulario', [
            'nome' => $personagem->nome,
            'retrato' => $personagem->retrato_caminho,
            'estrutura' => $estrutura,
            'valores' => $personagem->valores ?? [],
            'rolar' => null,
        ])
    </form>

    <div class="ficha-corpo" style="padding-top: 0">
        <section class="painel painel--perigo faixa">
            <div class="faixa__texto">
                <h2>Excluir personagem</h2>
                <span>Cópias já importadas para mesas continuam existindo lá.</span>
            </div>
            <form method="POST" action="{{ route('personagens.excluir', $personagem) }}" onsubmit="return confirm('Excluir {{ $personagem->nome }} da sua conta?')">
                @csrf @method('DELETE')
                <button type="submit" class="botao botao--perigo" style="height: 40px">Excluir</button>
            </form>
        </section>
    </div>
@endsection
