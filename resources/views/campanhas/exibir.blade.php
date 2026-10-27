{{--
    Campanha — menu da mesa. Rota: campanhas.exibir (CampanhaController@exibir).
    Espera: $campanha com ->sistema, ->mestre, ->membros (usuários com ->pivot->papel e ->pivot->pode_criar_itens).
    Papel do usuário logado: $campanha->papelDe(auth()->user()) — se o seu model usa outro nome, ajuste a linha abaixo.
--}}
@extends('layouts.app')

@section('titulo', $campanha->nome)

@section('conteudo')
    @php
        $eu = auth()->user();
        $meuPapel = $campanha->membros->firstWhere('id', $eu->id)?->pivot->papel;
    @endphp

    <a href="{{ route('inicio') }}" class="voltar">
        @include('parciais.icone', ['nome' => 'voltar', 'tamanho' => 14, 'espessura' => 2.5])
        Minhas campanhas
    </a>

    <header class="cabecalho" style="align-items: flex-start">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap">
                <h1>{{ $campanha->nome }}</h1>
                @if ($meuPapel)
                    <span class="selo selo--{{ \Illuminate\Support\Str::slug($meuPapel->name) }}">VOCÊ É {{ mb_strtoupper($meuPapel->rotulo()) }}</span>
                @endif
            </div>
            <p>{{ $campanha->sistema->nome }} · criada em {{ $campanha->created_at->format('d/m/Y') }} · mestre: {{ $campanha->mestre->nome }}</p>
        </div>
        <div class="acoes">
            @can('atualizar', $campanha)
                <a href="{{ route('campanhas.editar', $campanha) }}" class="botao botao--contorno">Editar</a>
            @endcan
            <a href="{{ route('mesa.exibir', $campanha) }}" class="botao botao--ambar" style="font-size: 15px; padding: 0 20px">
                @include('parciais.icone', ['nome' => 'seta', 'tamanho' => 16, 'espessura' => 2.5])
                Entrar na mesa
            </a>
        </div>
    </header>

    <div class="grade grade--3">
        <section class="painel grade__2col" aria-labelledby="t-sobre">
            <h2 id="t-sobre" class="painel__titulo">Sobre a campanha</h2>
            @if ($campanha->descricao)
                <p style="margin: 0; line-height: 1.55; color: var(--texto-medio)">{{ $campanha->descricao }}</p>
            @else
                <p class="fraco" style="margin: 0">O mestre ainda não escreveu uma descrição.</p>
            @endif
        </section>

        @can('gerirParticipantes', $campanha)
            <section class="painel" aria-labelledby="t-convite">
                <h2 id="t-convite" class="painel__titulo">Convite</h2>
                <div class="campo">Código
                    <div style="display: flex; gap: 8px; align-items: center">
                        <code class="entrada entrada--mono" style="display: flex; align-items: center; font-size: 16px; letter-spacing: 3px; color: #fff">{{ $campanha->codigo_convite }}</code>
                        <button type="button" class="botao botao--contorno botao--icone" aria-label="Copiar código"
                                onclick="navigator.clipboard.writeText('{{ $campanha->codigo_convite }}')">
                            @include('parciais.icone', ['nome' => 'copiar', 'tamanho' => 16])
                        </button>
                    </div>
                </div>
                <div class="campo">Senha da mesa
                    <a href="{{ route('campanhas.editar', $campanha) }}#senha" class="botao botao--contorno botao--pequeno" style="height: 40px">Redefinir senha</a>
                    <span class="apagado">A senha é guardada com hash; não dá para ver, só trocar.</span>
                </div>
            </section>
        @else
            <section class="painel" aria-labelledby="t-voce">
                <h2 id="t-voce" class="painel__titulo">Você nesta mesa</h2>
                <p style="margin: 0; color: var(--texto-medio)">
                    @if ($meuPapel === \App\Enums\PapelCampanha::Espectador)
                        Você entrou como espectador. Quando o mestre definir seu papel, você poderá criar sua ficha e rolar dados.
                    @else
                        Você participa como {{ mb_strtolower($meuPapel?->rotulo()) }}.
                    @endif
                </p>
                @can('sair', $campanha)
                    <form method="POST" action="{{ route('campanhas.sair', $campanha) }}" onsubmit="return confirm('Sair desta campanha? Suas fichas ficam na mesa.')">
                        @csrf
                        <button type="submit" class="botao botao--discreto botao--pequeno">Sair da campanha</button>
                    </form>
                @endcan
            </section>
        @endcan

        <section class="painel grade__3col" aria-labelledby="t-participantes">
            <div class="painel__topo">
                <h2 id="t-participantes" class="painel__titulo">Participantes <span class="fraco" style="font-weight: 500">· {{ $campanha->membros->count() }}</span></h2>
                <span class="fraco" style="font-size: 13px">Quem entra começa como espectador. Só o mestre e co-mestres mudam papéis.</span>
            </div>
            @include('campanhas.parciais.participantes')
        </section>

        @can('excluir', $campanha)
            <section class="painel painel--perigo grade__3col faixa" aria-labelledby="t-perigo">
                <div class="faixa__texto">
                    <h2 id="t-perigo">Excluir campanha</h2>
                    <span>Apaga biblioteca, fichas, chat, rolagens e cenas em cascata. Não há arquivamento.</span>
                </div>
                <form method="POST" action="{{ route('campanhas.excluir', $campanha) }}" onsubmit="return confirm('Excluir a campanha e tudo o que está nela? Não dá para desfazer.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="botao botao--perigo" style="height: 40px">Excluir campanha</button>
                </form>
            </section>
        @endcan
    </div>
@endsection
