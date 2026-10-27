{{--
    Personagens da conta. Rota: personagens.listar (PersonagemController@listar).
    Espera: $personagens (do usuário, com ->sistema e ->tipo TipoFicha),
            $sistemas (publicados, para o filtro e o botão de criar).
    Filtros via query string: ?tipo=pj|npc&sistema=slug
    Importação para a mesa: rota personagens.importar (etapa 4) — só aparece se existir.
--}}
@extends('layouts.app')

@section('titulo', 'Meus personagens')

@section('conteudo')
    @php
        $tipoFiltro = request('tipo');
        $sistemaFiltro = request('sistema');
    @endphp

    <header class="cabecalho">
        <div>
            <h1>Meus personagens</h1>
            <p>Fichas que vivem na sua conta. Importar para uma mesa cria uma cópia independente.</p>
        </div>
        <details class="suspenso">
            <summary class="botao botao--primario">
                @include('parciais.icone', ['nome' => 'mais', 'tamanho' => 16, 'espessura' => 2.5])
                Novo personagem
            </summary>
            <form method="GET" action="{{ route('personagens.criar') }}" class="suspenso__painel">
                <label for="novo-sistema" class="campo">Sistema
                    <select id="novo-sistema" name="sistema" class="selecao" required>
                        @foreach ($sistemas as $sistema)
                            <option value="{{ $sistema->slug }}">{{ $sistema->nome }}</option>
                        @endforeach
                    </select>
                </label>
                <label for="novo-tipo" class="campo">Tipo
                    <select id="novo-tipo" name="tipo" class="selecao">
                        <option value="pj">Personagem (PJ)</option>
                        <option value="npc">NPC / ameaça</option>
                    </select>
                </label>
                <button type="submit" class="botao botao--primario botao--largo">Começar</button>
            </form>
        </details>
    </header>

    <form method="GET" class="filtros" role="group" aria-label="Filtros">
        <a href="{{ route('personagens.listar', array_filter(['sistema' => $sistemaFiltro])) }}" class="pilula {{ $tipoFiltro ? '' : 'ativa' }}">Todos</a>
        <a href="{{ route('personagens.listar', array_filter(['tipo' => 'pj', 'sistema' => $sistemaFiltro])) }}" class="pilula {{ $tipoFiltro === 'pj' ? 'ativa' : '' }}">Personagens (PJ)</a>
        <a href="{{ route('personagens.listar', array_filter(['tipo' => 'npc', 'sistema' => $sistemaFiltro])) }}" class="pilula {{ $tipoFiltro === 'npc' ? 'ativa' : '' }}">NPCs e ameaças</a>
        <span class="divisor-v"></span>
        @if ($tipoFiltro) <input type="hidden" name="tipo" value="{{ $tipoFiltro }}"> @endif
        <label class="campo campo--linha">Sistema
            <select name="sistema" class="selecao selecao--compacta" style="width: auto" onchange="this.form.submit()">
                <option value="">Todos os sistemas</option>
                @foreach ($sistemas as $sistema)
                    <option value="{{ $sistema->slug }}" @selected($sistemaFiltro === $sistema->slug)>{{ $sistema->nome }}</option>
                @endforeach
            </select>
        </label>
    </form>

    <div class="grade grade--3">
        @forelse ($personagens as $personagem)
            @php
                $ehNpc = $personagem->tipo === \App\Enums\TipoFicha::Npc;
                $iniciais = \Illuminate\Support\Str::of($personagem->nome)->explode(' ')->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode('');
            @endphp
            <article class="cartao cartao--personagem">
                <div class="cartao__pessoa">
                    <div class="iniciais {{ $ehNpc ? 'iniciais--npc' : '' }}" aria-hidden="true">{{ mb_strtoupper($iniciais) }}</div>
                    <div style="min-width: 0">
                        <h2>{{ $personagem->nome }}</h2>
                        <span>{{ $personagem->sistema->nome }} · {{ $personagem->tipo->rotulo() }}</span>
                    </div>
                </div>
                <div style="display: flex; gap: 6px; align-items: center">
                    <span class="selo selo--{{ $ehNpc ? 'npc' : 'pj' }}">{{ $ehNpc ? 'NPC' : 'PJ' }}</span>
                    <span class="fraco pequeno">Atualizado {{ $personagem->updated_at->diffForHumans() }}</span>
                </div>
                <div class="cartao__acoes">
                    <a href="{{ route('personagens.exibir', $personagem) }}" class="botao botao--primario">Editar ficha</a>
                    @if (Route::has('personagens.importar'))
                        <a href="{{ route('personagens.importar', $personagem) }}" class="botao botao--contorno" style="flex: 0 0 auto; padding: 0 14px">Importar</a>
                    @endif
                </div>
            </article>
        @empty
            <p class="fraco grade__3col">Você ainda não tem personagens. Crie o primeiro abaixo.</p>
        @endforelse

        <div id="novo" class="cartao cartao--novo" style="gap: 12px">
            @include('parciais.icone', ['nome' => 'mais', 'tamanho' => 28])
            <strong>Criar personagem ou NPC</strong>
            <span>Escolha o sistema e o tipo; a ficha vem da estrutura publicada</span>
            <form method="GET" action="{{ route('personagens.criar') }}" style="display: flex; gap: 8px; flex-wrap: wrap; justify-content: center; width: 100%">
                <select name="sistema" class="selecao selecao--compacta" style="width: auto" aria-label="Sistema" required>
                    @foreach ($sistemas as $sistema)
                        <option value="{{ $sistema->slug }}">{{ $sistema->nome }}</option>
                    @endforeach
                </select>
                <select name="tipo" class="selecao selecao--compacta" style="width: auto" aria-label="Tipo">
                    <option value="pj">Personagem (PJ)</option>
                    <option value="npc">NPC / ameaça</option>
                </select>
                <button type="submit" class="botao botao--roxo botao--pequeno">Começar</button>
            </form>
        </div>
    </div>
@endsection
