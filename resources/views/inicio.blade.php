{{--
    Início — minhas campanhas. Rota: inicio (CampanhaController@listar).
    Espera: $campanhas = campanhas do usuário com ->pivot->papel (PapelCampanha),
            ->sistema (SistemaJogo) e ->membros_count (withCount('membros')).
--}}
@extends('layouts.app')

@section('titulo', 'Minhas campanhas')

@section('conteudo')
    <header class="cabecalho">
        <div>
            <h1>Minhas campanhas</h1>
            <p>Mesas em que você é mestre, co-mestre, jogador ou espectador.</p>
        </div>
        <div class="acoes">
            <a href="#entrar" class="botao botao--contorno">Entrar com código</a>
            <a href="{{ route('campanhas.criar') }}" class="botao botao--primario">
                @include('parciais.icone', ['nome' => 'mais', 'tamanho' => 16, 'espessura' => 2.5])
                Nova campanha
            </a>
        </div>
    </header>

    <form id="entrar" method="POST" action="{{ route('campanhas.entrar') }}" class="painel faixa" aria-label="Entrar em uma campanha">
        @csrf
        <div class="faixa__texto">
            <strong>Recebeu um convite?</strong>
            <span>Digite o código de 8 caracteres e a senha da mesa. Você entra como espectador até o mestre definir seu papel.</span>
        </div>
        <label class="campo">Código
            <input type="text" name="codigo_convite" value="{{ old('codigo_convite') }}" maxlength="8" placeholder="AB12CD34" required
                   class="entrada entrada--mono" style="width: 140px" autocapitalize="characters">
        </label>
        <label class="campo">Senha
            <input type="password" name="senha" required class="entrada" style="width: 160px">
        </label>
        <button type="submit" class="botao botao--roxo botao--pequeno" style="margin-top: 18px; height: 40px">Entrar</button>
    </form>

    <div class="grade grade--3">
        @foreach ($campanhas as $campanha)
            @php
                $papel = $campanha->pivot->papel;
                $classePapel = \Illuminate\Support\Str::slug($papel->name);
            @endphp
            <article class="cartao">
                <div class="cartao__capa cartao__capa--{{ $classePapel }}">
                    @include('parciais.selo-papel', ['papel' => $papel])
                </div>
                <div class="cartao__corpo">
                    <h2>{{ $campanha->nome }}</h2>
                    <span class="fraco pequeno" style="font-size: 13px">
                        {{ $campanha->sistema->nome }} · {{ $campanha->membros_count ?? $campanha->membros->count() }} participantes
                    </span>
                    @if ($campanha->descricao)
                        <p>{{ \Illuminate\Support\Str::limit($campanha->descricao, 110) }}</p>
                    @elseif ($papel === \App\Enums\PapelCampanha::Espectador)
                        <p>Aguardando o mestre definir seu papel.</p>
                    @endif
                    <div class="cartao__acoes">
                        <a href="{{ route('campanhas.exibir', $campanha) }}" class="botao botao--primario">Abrir</a>
                        @if ($papel === \App\Enums\PapelCampanha::Espectador)
                            @can('sair', $campanha)
                                <form method="POST" action="{{ route('campanhas.sair', $campanha) }}" style="flex: 1; display: flex">
                                    @csrf
                                    <button type="submit" class="botao botao--discreto" style="flex: 1">Sair da mesa</button>
                                </form>
                            @endcan
                        @else
                            <a href="{{ route('mesa.exibir', $campanha) }}" class="botao botao--contorno">Ir para a mesa</a>
                        @endif
                    </div>
                </div>
            </article>
        @endforeach

        <a href="{{ route('campanhas.criar') }}" class="cartao cartao--novo">
            @include('parciais.icone', ['nome' => 'mais', 'tamanho' => 28])
            <strong>Criar uma nova campanha</strong>
            <span>Escolha o sistema e defina a senha da mesa</span>
        </a>
    </div>
@endsection
