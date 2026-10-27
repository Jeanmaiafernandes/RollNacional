{{--
    Tela de um item da biblioteca (pasta ou anotação): leitura para quem só vê, edição para quem pode.
    Rotas: biblioteca.exibir (GET) → biblioteca.atualizar (PUT) / biblioteca.excluir (DELETE).
    Espera: $campanha, $item (com ->pasta, ->dono, ->usuariosVisiveis), $pastas (pastas da campanha sem a própria e descendentes),
            $participantes (membros, para visibilidade específica).
    Campos: nome, pasta_id, visibilidade (oculto|todos|especifico), visivel_para[] (ids), conteudo[texto].
--}}
@extends('layouts.app')
@section('titulo', $item->nome)
@section('conteudo')
    @php
        $podeEditar = auth()->user()->can('atualizar', $item);
        $ehPasta = $item->tipo === \App\Enums\TipoItemBiblioteca::Pasta;
        $visibilidade = old('visibilidade', $item->visibilidade?->value ?? 'oculto');
        $selecionados = collect(old('visivel_para', $item->usuariosVisiveis?->pluck('id') ?? []));
    @endphp
    <a href="{{ route('mesa.exibir', $campanha) }}" class="voltar">@include('parciais.icone', ['nome' => 'voltar', 'tamanho' => 14, 'espessura' => 2.5]) Mesa · {{ $campanha->nome }}</a>

    <header class="cabecalho">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap">
                <h1>{{ $item->nome }}</h1>
                <span class="selo">{{ mb_strtoupper($item->tipo->rotulo()) }}</span>
                @if ($item->fixo) <span class="selo selo--mestre">FIXA</span> @endif
            </div>
            <p>
                @if ($item->pasta) Em <a href="{{ route('biblioteca.exibir', [$campanha, $item->pasta]) }}">{{ $item->pasta->nome }}</a> · @else Na raiz · @endif
                @if ($item->dono) criado por {{ $item->dono->nome }} · @endif
                atualizado {{ $item->updated_at->diffForHumans() }}
            </p>
        </div>
    </header>

    @if (! $podeEditar)
        <section class="painel">
            @if ($ehPasta)
                <p class="fraco" style="margin: 0">Pasta. Abra os itens pela biblioteca da mesa.</p>
            @else
                <div style="white-space: pre-wrap; line-height: 1.6; color: var(--texto-medio)">{{ data_get($item->conteudo, 'texto') ?: '—' }}</div>
            @endif
        </section>
    @else
        <form method="POST" action="{{ route('biblioteca.atualizar', [$campanha, $item]) }}" class="grade grade--3">
            @csrf @method('PUT')
            <section class="painel grade__2col" style="gap: 16px">
                <label for="nome" class="campo">Nome
                    <input type="text" id="nome" name="nome" value="{{ old('nome', $item->nome) }}" required maxlength="80" class="entrada entrada--grande" @disabled($item->fixo)>
                </label>
                <label for="pasta_id" class="campo">Dentro de
                    <select id="pasta_id" name="pasta_id" class="selecao" @disabled($item->fixo)>
                        <option value="">Raiz da biblioteca</option>
                        @foreach ($pastas as $pasta)
                            <option value="{{ $pasta->id }}" @selected(old('pasta_id', $item->pasta_id) == $pasta->id)>{{ str_repeat('— ', $pasta->nivel ?? 0) }}{{ $pasta->nome }}</option>
                        @endforeach
                    </select>
                </label>
                @unless ($ehPasta)
                    <label for="texto" class="campo">Texto
                        <textarea id="texto" name="conteudo[texto]" rows="14" class="area">{{ old('conteudo.texto', data_get($item->conteudo, 'texto')) }}</textarea>
                    </label>
                @endunless
                <div class="acoes">
                    <button type="submit" class="botao botao--primario">Salvar</button>
                    <a href="{{ route('mesa.exibir', $campanha) }}" class="botao botao--contorno">Voltar à mesa</a>
                </div>
            </section>

            <section class="painel" style="gap: 14px">
                <h2 class="painel__titulo">Quem vê</h2>
                @foreach ([['oculto', 'Só mestre e co-mestres', 'cadeado'], ['todos', 'Todos os participantes', 'pessoa'], ['especifico', 'Participantes escolhidos', 'lista']] as [$valor, $rotulo, $icone])
                    <label class="marcar" style="gap: 10px; padding: 8px 10px; border-radius: 8px; border: 1px solid {{ $visibilidade === $valor ? 'var(--primario)' : 'var(--borda)' }}">
                        <input type="radio" name="visibilidade" value="{{ $valor }}" @checked($visibilidade === $valor) class="caixa">
                        @include('parciais.icone', ['nome' => $icone, 'tamanho' => 14])
                        {{ $rotulo }}
                    </label>
                @endforeach
                <div id="bloco-especifico" style="display: flex; flex-direction: column; gap: 6px; padding-left: 10px" @if ($visibilidade !== 'especifico') hidden @endif>
                    @foreach ($participantes as $membro)
                        @continue($membro->pivot->papel === \App\Enums\PapelCampanha::Mestre)
                        <label class="marcar"><input type="checkbox" name="visivel_para[]" value="{{ $membro->id }}" class="caixa" @checked($selecionados->contains($membro->id))> {{ $membro->nome }}</label>
                    @endforeach
                </div>
                <span class="apagado pequeno">{{ $ehPasta ? 'Pasta oculta esconde tudo o que está dentro dela.' : 'Jogador dono vê a própria anotação mesmo oculta.' }}</span>
            </section>
        </form>

        @unless ($item->fixo)
            <section class="painel painel--perigo faixa">
                <div class="faixa__texto">
                    <h2>Excluir item</h2>
                    <span>{{ $ehPasta ? 'Apaga a pasta e tudo o que está dentro.' : 'Não dá para desfazer.' }}</span>
                </div>
                <form method="POST" action="{{ route('biblioteca.excluir', [$campanha, $item]) }}" onsubmit="return confirm('Excluir {{ $item->nome }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="botao botao--perigo" style="height: 40px">Excluir</button>
                </form>
            </section>
        @endunless
    @endif
@endsection

@push('scripts')
<script>
    document.querySelectorAll('input[name="visibilidade"]').forEach(r => r.addEventListener('change', () => {
        document.getElementById('bloco-especifico').hidden = r.value !== 'especifico';
        document.querySelectorAll('input[name="visibilidade"]').forEach(o => o.closest('label').style.borderColor = o.checked ? 'var(--primario)' : 'var(--borda)');
    }));
</script>
@endpush
