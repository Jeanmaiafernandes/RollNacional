{{--
    Admin — sistemas de jogo (lista + detalhe na mesma tela). Protegida por can:administrar.
    Rotas (etapa do admin, ainda a criar): admin.sistemas.listar (?sistema=slug), admin.sistemas.criar, admin.sistemas.editar,
      admin.sistemas.versoes.salvar (POST sistema) e admin.sistemas.versoes.publicar (POST versao).
    Espera: $sistemas (com ->versoes e ->campanhas_count), $sistemaSelecionado (ou null), $versaoEmEdicao (rascunho ou null).
    $versaoEmEdicao->estrutura_ficha é o array {pj: {...}, npc: {...}}; ?tipo=pj|npc escolhe qual editar.
--}}
@extends('layouts.app')

@section('titulo', 'Sistemas de jogo')

@section('conteudo')
    @php
        $sistema = $sistemaSelecionado ?? $sistemas->first();
        $tipo = request('tipo', 'pj');
        $versao = $versaoEmEdicao ?? $sistema?->versoes->firstWhere('status', \App\Enums\StatusVersao::Rascunho);
        $publicada = $sistema?->versoes->where('status', \App\Enums\StatusVersao::Publicada)->sortByDesc('publicada_em')->first();
        $json = old('estrutura_ficha', json_encode(data_get($versao?->estrutura_ficha ?? $publicada?->estrutura_ficha, $tipo, new stdClass), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    @endphp

    <header class="cabecalho">
        <div>
            <h1>Sistemas de jogo</h1>
            <p>Cadastro do site. A ficha sempre usa a versão publicada mais recente — só acrescente campos, nunca renomeie chaves.</p>
        </div>
        @if (Route::has('admin.sistemas.criar'))
            <a href="{{ route('admin.sistemas.criar') }}" class="botao botao--primario">
                @include('parciais.icone', ['nome' => 'mais', 'tamanho' => 16, 'espessura' => 2.5])
                Novo sistema
            </a>
        @endif
    </header>

    <div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-start">

        <section class="painel lista-sistemas" style="flex: 1 1 300px" aria-label="Lista de sistemas">
            @foreach ($sistemas as $s)
                @php $statusClasse = \Illuminate\Support\Str::slug($s->status->name); @endphp
                <a href="{{ route('admin.sistemas.listar', ['sistema' => $s->slug]) }}" class="lista-sistemas__item {{ $sistema?->is($s) ? 'ativo' : '' }}">
                    <div class="painel__topo">
                        <strong>{{ $s->nome }}</strong>
                        <span class="selo selo--{{ $statusClasse }}">{{ mb_strtoupper($s->status->rotulo()) }}</span>
                    </div>
                    <span>
                        {{ $s->editora ?: 'sem editora' }} · <code>{{ $s->slug }}</code>
                        @if ($v = $s->versoes->where('status', \App\Enums\StatusVersao::Publicada)->sortByDesc('publicada_em')->first()) · v{{ $v->numero }} @endif
                        · {{ $s->campanhas_count ?? $s->campanhas()->count() }} {{ ($s->campanhas_count ?? 0) === 1 ? 'campanha' : 'campanhas' }}
                    </span>
                    @if ($s->aviso_licenca)
                        <span style="color: var(--rosa)">{{ \Illuminate\Support\Str::limit($s->aviso_licenca, 70) }}</span>
                    @endif
                </a>
            @endforeach
        </section>

        @if ($sistema)
            <section style="flex: 2 1 480px; min-width: 0; display: flex; flex-direction: column; gap: 16px" aria-labelledby="t-sistema">
                <div class="painel">
                    <div class="painel__topo">
                        <h2 id="t-sistema" style="font-size: 18px">{{ $sistema->nome }}</h2>
                        <div class="acoes">
                            @if (Route::has('admin.sistemas.editar'))
                                <a href="{{ route('admin.sistemas.editar', $sistema) }}" class="botao botao--contorno botao--pequeno">Editar informações</a>
                            @endif
                        </div>
                    </div>
                    <div class="dados">
                        <div><span>Editora</span><span>{{ $sistema->editora ?: '—' }}</span></div>
                        <div><span>Modelo base</span><span>{{ $sistema->modelo_base ?: '—' }}</span></div>
                        <div><span>Aviso de licença</span><span style="color: var(--ambar)">{{ $sistema->aviso_licenca ?: '—' }}</span></div>
                    </div>
                    @if ($sistema->descricao)
                        <p style="margin: 0; color: var(--texto-medio); font-size: 14px">{{ $sistema->descricao }}</p>
                    @endif
                </div>

                <div class="painel">
                    <div class="painel__topo">
                        <h3 style="font-size: 15px">Versões</h3>
                        @if (Route::has('admin.sistemas.versoes.salvar') && ! $versao)
                            <form method="POST" action="{{ route('admin.sistemas.versoes.salvar', $sistema) }}">
                                @csrf
                                <input type="hidden" name="baseado_em_id" value="{{ $publicada?->id }}">
                                <button type="submit" class="botao botao--roxo botao--pequeno">Nova versão{{ $publicada ? ' a partir da ' . $publicada->numero : '' }}</button>
                            </form>
                        @endif
                    </div>
                    @forelse ($sistema->versoes->sortByDesc('numero') as $v)
                        @php $statusV = \Illuminate\Support\Str::slug($v->status->name); @endphp
                        <div class="versao">
                            <strong>{{ $v->numero }}</strong>
                            <span class="selo selo--{{ $statusV }}">{{ mb_strtoupper($v->status->rotulo()) }}</span>
                            <span style="color: var(--texto-medio)">{{ $v->notas_alteracao ?: 'sem notas' }}</span>
                            <span class="apagado">
                                @if ($v->publicada_em) {{ $v->publicada_em->format('d/m/Y') }} · imutável
                                @elseif ($versao?->is($v)) editando abaixo
                                @endif
                            </span>
                        </div>
                    @empty
                        <p class="fraco" style="margin: 0">Nenhuma versão ainda.</p>
                    @endforelse
                </div>

                @if ($versao || $publicada)
                    <form method="POST" class="painel"
                          action="{{ $versao && Route::has('admin.sistemas.versoes.atualizar') ? route('admin.sistemas.versoes.atualizar', $versao) : '#' }}">
                        @csrf @method('PUT')
                        <input type="hidden" name="tipo" value="{{ $tipo }}">
                        <div class="painel__topo">
                            <h3 style="font-size: 15px">
                                Estrutura da ficha — v{{ ($versao ?? $publicada)->numero }}
                                <span class="fraco" style="font-weight: 500">({{ $versao ? 'rascunho' : 'publicada, somente leitura' }})</span>
                            </h3>
                            <div class="alternador" role="group" aria-label="Tipo de ficha">
                                <a href="{{ route('admin.sistemas.listar', ['sistema' => $sistema->slug, 'tipo' => 'pj']) }}" class="{{ $tipo === 'pj' ? 'ativo' : '' }}">PJ</a>
                                <a href="{{ route('admin.sistemas.listar', ['sistema' => $sistema->slug, 'tipo' => 'npc']) }}" class="{{ $tipo === 'npc' ? 'ativo' : '' }}">NPC</a>
                            </div>
                        </div>
                        <label for="json-estrutura" class="campo">JSON da estrutura (validado pelo ValidadorDeEstrutura ao salvar)</label>
                        <textarea id="json-estrutura" name="estrutura_ficha" rows="16" spellcheck="false" class="area area--codigo" @readonly(! $versao)>{{ $json }}</textarea>
                        @if ($versao)
                            <div class="painel__topo">
                                <label for="notas" class="campo" style="flex: 1 1 260px">Notas da versão
                                    <input type="text" id="notas" name="notas_alteracao" value="{{ old('notas_alteracao', $versao->notas_alteracao) }}" class="entrada entrada--compacta">
                                </label>
                                <div class="acoes">
                                    <button type="submit" class="botao botao--primario" style="height: 40px">Salvar rascunho</button>
                                    @if (Route::has('admin.sistemas.versoes.publicar'))
                                        <button type="submit" form="form-publicar" class="botao botao--ambar" style="height: 40px"
                                                onclick="return confirm('Publicar a versão {{ $versao->numero }}? Depois de publicada ela não pode ser alterada.')">Publicar v{{ $versao->numero }}</button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </form>
                    @if ($versao && Route::has('admin.sistemas.versoes.publicar'))
                        <form id="form-publicar" method="POST" action="{{ route('admin.sistemas.versoes.publicar', $versao) }}">@csrf</form>
                    @endif
                @endif
            </section>
        @endif
    </div>
@endsection
