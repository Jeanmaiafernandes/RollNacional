{{--
    Mesa digital. Rota: mesa.exibir (MesaController@exibir).
    Espera:
      $campanha        com ->membros (pivot papel), ->mestre, ->cenaAtiva (ItemBiblioteca tipo cena ou null)
      $arvore          raiz da biblioteca já filtrada pela visibilidade (ArvoreDaBiblioteca) — cada nó: ->item, ->filhos
      $tokens          tokens da cena ativa com ->ficha->item (nome, visibilidade), coluna, linha
      $historico       mensagens e rolagens misturadas em ordem cronológica (Mensagem | Rolagem), já filtradas (secretas só p/ mestre)
      $fichasQueFalo   fichas pelas quais o usuário pode falar (jogador: a sua; mestre: NPCs) — opcional
      $pastas          pastas da campanha (para o "Dentro de" do form de novo item) — opcional
    Rotas usadas se existirem: mensagens.salvar, biblioteca.salvar, fichas.exibir, cenas.ativar.
    Tempo real (Reverb) entra depois: por ora o form faz POST → redirect.
--}}
@extends('layouts.mesa')

@section('titulo', $campanha->nome)

@section('conteudo')
    @php
        $eu = auth()->user();
        $meuPapel = $campanha->membros->firstWhere('id', $eu->id)?->pivot->papel;
        $souMestre = in_array($meuPapel, [\App\Enums\PapelCampanha::Mestre, \App\Enums\PapelCampanha::CoMestre], true);
        $cena = $campanha->cenaAtiva ?? null;
        $grid = data_get($cena?->conteudo, 'grid', []);
        $celula = (int) data_get($grid, 'celula_px', 56);
        $iniciaisDe = fn ($nome) => mb_strtoupper(\Illuminate\Support\Str::of($nome)->explode(' ')->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode(''));
    @endphp

    <div class="mesa">
        <header class="mesa__topo">
            <a href="{{ route('campanhas.exibir', $campanha) }}" class="mesa__voltar" aria-label="Voltar para a campanha">
                @include('parciais.icone', ['nome' => 'voltar', 'tamanho' => 16, 'espessura' => 2.5])
            </a>
            @include('parciais.icone', ['nome' => 'd20', 'tamanho' => 22, 'cor' => 'var(--primario)'])
            <h1>{{ $campanha->nome }}</h1>
            <span class="apagado pequeno">Cena ativa: <span style="color: var(--texto-medio)">{{ $cena?->nome ?? 'nenhuma' }}</span></span>
            <div style="flex-grow: 1"></div>
            <div class="presentes" aria-label="Participantes">
                @foreach ($campanha->membros as $membro)
                    @php $ehMestre = $membro->pivot->papel === \App\Enums\PapelCampanha::Mestre; @endphp
                    <span class="avatar {{ $ehMestre ? 'avatar--mestre' : '' }}" title="{{ $membro->nome }} ({{ $membro->pivot->papel->rotulo() }})">{{ $iniciaisDe($membro->nome) }}</span>
                @endforeach
            </div>
            @if ($meuPapel) @include('parciais.selo-papel', ['papel' => $meuPapel]) @endif
        </header>

        <div class="mesa__corpo">
            {{-- ======== Biblioteca ======== --}}
            <aside class="biblioteca" aria-label="Biblioteca da mesa">
                <div class="biblioteca__topo">
                    <strong>Biblioteca</strong>
                    @if ($campanha->podeCriarItens($eu))
                        <button type="button" class="botao--ferramenta" aria-label="Novo item" aria-expanded="false" aria-controls="novo-item"
                                onclick="const d = document.getElementById('novo-item'); d.open = !d.open; this.setAttribute('aria-expanded', d.open)">
                            @include('parciais.icone', ['nome' => 'mais', 'tamanho' => 14, 'espessura' => 2.5])
                        </button>
                    @endif
                </div>

                @if ($campanha->podeCriarItens($eu))
                    <details id="novo-item" @open($errors->any() && old('_form') === 'novo-item')>
                        <summary style="display: none"></summary>
                        @include('mesa.parciais.novo-item', ['campanha' => $campanha, 'pastas' => $pastas ?? collect(), 'souMestre' => $souMestre])
                    </details>
                @endif
                <div class="biblioteca__lista arvore">
                    @foreach ($arvore as $no)
                        @include('mesa.parciais.arvore-item', ['no' => $no, 'campanha' => $campanha, 'cena' => $cena, 'souMestre' => $souMestre])
                    @endforeach
                </div>
                <div class="biblioteca__rodape">
                    @include('parciais.icone', ['nome' => 'cadeado', 'tamanho' => 12])
                    cadeado = oculto aos jogadores
                </div>
            </aside>

            {{-- ======== Tabuleiro ======== --}}
            <section class="tabuleiro" aria-label="Tabuleiro">
                @if ($souMestre)
                    <div class="ferramentas" role="toolbar" aria-label="Ferramentas da cena">
                        <button type="button" aria-label="Selecionar" aria-pressed="true" data-ferramenta="selecionar">@include('parciais.icone', ['nome' => 'selecionar', 'tamanho' => 16])</button>
                        <button type="button" aria-label="Mover mapa" data-ferramenta="mover">@include('parciais.icone', ['nome' => 'mover', 'tamanho' => 16])</button>
                        <button type="button" aria-label="Medir distância" data-ferramenta="medir">@include('parciais.icone', ['nome' => 'medir', 'tamanho' => 16])</button>
                        <button type="button" aria-label="Névoa de guerra" data-ferramenta="nevoa">@include('parciais.icone', ['nome' => 'nevoa', 'tamanho' => 16])</button>
                        <button type="button" aria-label="Adicionar token" data-ferramenta="token">@include('parciais.icone', ['nome' => 'token', 'tamanho' => 16])</button>
                    </div>
                @endif

                <div class="mapa" id="mapa"
                     style="--celula: {{ $celula }}px; --desloc-x: {{ (int) data_get($grid, 'deslocamento_x', 0) }}px; --desloc-y: {{ (int) data_get($grid, 'deslocamento_y', 0) }}px"
                     aria-label="Mapa: {{ $cena?->nome ?? 'sem cena' }}">
                    @if ($cena)
                        @if ($mapa = data_get($cena->conteudo, 'mapa'))
                            <img src="{{ Route::has('cenas.mapa') ? route('cenas.mapa', $cena) : asset('storage/' . $mapa) }}" alt="" class="mapa__imagem">
                        @endif

                        @foreach ($tokens as $token)
                            @php
                                $item = $token->ficha->item;
                                $ehNpc = $token->ficha->tipo === \App\Enums\TipoFicha::Npc;
                                $oculto = $item->visibilidade === \App\Enums\Visibilidade::Oculto;
                                $x = (int) data_get($grid, 'deslocamento_x', 0) + $token->coluna * $celula;
                                $y = (int) data_get($grid, 'deslocamento_y', 0) + $token->linha * $celula;
                                $vida = $token->ficha->valor('pv');
                            @endphp
                            @continue($oculto && ! $souMestre)
                            <a href="{{ Route::has('fichas.exibir') ? route('fichas.exibir', $token->ficha) : route('biblioteca.exibir', [$campanha, $item]) }}"
                               class="token {{ $ehNpc ? 'token--npc' : '' }} {{ $oculto ? 'token--oculto' : '' }}"
                               style="left: {{ $x }}px; top: {{ $y }}px"
                               data-token="{{ $token->id }}"
                               aria-label="Token: {{ $item->nome }}{{ $oculto ? ', oculto aos jogadores' : '' }}">
                                @if ($token->ficha->retrato_caminho)
                                    <img src="{{ Route::has('fichas.retrato') ? route('fichas.retrato', $token->ficha) : asset('storage/' . $token->ficha->retrato_caminho) }}" alt="">
                                @else
                                    {{ $iniciaisDe($item->nome) }}
                                @endif
                            </a>
                            @if ($souMestre && is_array($vida) && ($vida['maximo'] ?? 0) > 0)
                                <span class="token__vida" aria-hidden="true" style="left: {{ $x }}px; top: {{ $y + $celula + 4 }}px">
                                    <span style="width: {{ max(0, min(100, round($vida['atual'] / $vida['maximo'] * 100))) }}%"></span>
                                </span>
                            @endif
                        @endforeach

                        @if ($souMestre && data_get($cena->conteudo, 'nevoa'))
                            <div class="nevoa" aria-hidden="true"></div>
                            <span class="mapa__legenda">névoa · só o mestre vê através</span>
                        @endif
                    @else
                        <div class="mapa__vazio">
                            @include('parciais.icone', ['nome' => 'cena', 'tamanho' => 32])
                            <strong>Nenhuma cena ativa</strong>
                            <span class="pequeno">{{ $souMestre ? 'Crie uma cena na biblioteca e marque-a como ativa.' : 'Aguarde o mestre abrir uma cena.' }}</span>
                        </div>
                    @endif
                </div>

                <div class="tabuleiro__rodape">
                    @if ($cena)
                        <span>grid {{ data_get($grid, 'colunas', '?') }}×{{ data_get($grid, 'linhas', '?') }} · célula {{ data_get($grid, 'escala', '1,5 m') }}</span>
                    @endif
                    <span>zoom 100%</span>
                    <span class="direita" id="selecionado"></span>
                </div>
            </section>

            {{-- ======== Conversa ======== --}}
            <aside class="conversa" aria-label="Chat e rolagens">
                <div class="conversa__topo">
                    <strong>Conversa</strong>
                    <span class="ao-vivo" aria-hidden="true"></span>
                    <span class="apagado pequeno">ao vivo</span>
                </div>

                <div class="conversa__lista" id="conversa">
                    @forelse ($historico as $entrada)
                        @include('mesa.parciais.' . ($entrada instanceof \App\Models\Rolagem ? 'rolagem' : 'mensagem'), ['entrada' => $entrada, 'campanha' => $campanha])
                    @empty
                        <p class="apagado" style="text-align: center; margin: 24px 0">A mesa está posta. Diga algo ou role <code>/r 1d20</code>.</p>
                    @endforelse
                </div>

                @can('escrever', $campanha)
                    <form method="POST" action="{{ Route::has('mensagens.salvar') ? route('mensagens.salvar', $campanha) : '#' }}" class="conversa__form">
                        @csrf
                        <div class="conversa__opcoes">
                            @if (isset($fichasQueFalo) && $fichasQueFalo->isNotEmpty())
                                <label for="falar-como">Falar como</label>
                                <select id="falar-como" name="ficha_id" class="selecao selecao--mini" style="width: auto">
                                    <option value="">{{ $souMestre ? 'Mestre' : $eu->nome }}</option>
                                    @foreach ($fichasQueFalo as $ficha)
                                        <option value="{{ $ficha->id }}">{{ $ficha->item->nome }}</option>
                                    @endforeach
                                </select>
                            @endif
                            @can('rolarSecreto', $campanha)
                                <label class="marcar"><input type="checkbox" name="secreta" value="1" class="caixa" style="width: 14px; height: 14px; accent-color: var(--ambar)"> secreta</label>
                            @endcan
                        </div>
                        <div class="conversa__envio">
                            <input type="text" name="texto" required maxlength="2000" class="entrada" placeholder="Mensagem ou /r 1d20+5" aria-label="Mensagem" autocomplete="off">
                            <button type="submit" aria-label="Enviar">@include('parciais.icone', ['nome' => 'seta', 'tamanho' => 16, 'espessura' => 2.5])</button>
                        </div>
                    </form>
                @else
                    <div class="conversa__form apagado pequeno">Espectadores só acompanham a conversa.</div>
                @endcan
            </aside>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Mantém a conversa rolada até o fim e marca o token clicado no rodapé (interação completa vem com o tabuleiro, etapa 8).
    const conversa = document.getElementById('conversa');
    if (conversa) conversa.scrollTop = conversa.scrollHeight;
    document.querySelectorAll('.ferramentas button').forEach(b => b.addEventListener('click', () => {
        document.querySelectorAll('.ferramentas button').forEach(o => o.setAttribute('aria-pressed', 'false'));
        b.setAttribute('aria-pressed', 'true');
    }));
</script>
@endpush
