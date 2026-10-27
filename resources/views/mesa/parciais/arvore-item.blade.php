{{--
    Nó da árvore da biblioteca (recursivo). $no->item é um ItemBiblioteca; $no->filhos a coleção de nós.
    Pastas abrem/fecham com <details>; a pasta fixa "Personagens dos jogadores" começa aberta.
--}}
@php
    $item = $no->item;
    $tipo = $item->tipo;
    $oculto = $item->visibilidade === \App\Enums\Visibilidade::Oculto;
    $ehPasta = $tipo === \App\Enums\TipoItemBiblioteca::Pasta;
    $ehFicha = $tipo === \App\Enums\TipoItemBiblioteca::Ficha;
    $ehCena = $tipo === \App\Enums\TipoItemBiblioteca::Cena;
    $ehCenaAtiva = $ehCena && $cena && $cena->id === $item->id;
    $url = match (true) {
        $ehFicha && Route::has('fichas.exibir') => route('fichas.exibir', $item->ficha),
        Route::has('biblioteca.exibir') => route('biblioteca.exibir', [$campanha, $item]),
        default => '#',
    };
@endphp

@if ($ehPasta)
    <details @open($item->fixo)>
        <summary>
            @include('parciais.icone', ['nome' => 'pasta', 'tamanho' => 14, 'cor' => $item->fixo ? 'var(--ambar)' : 'var(--texto-fraco)'])
            {{ $item->nome }}
            @if ($item->fixo)
                <span class="arvore__fim">FIXA</span>
            @elseif ($oculto && $souMestre)
                <span class="arvore__fim">@include('parciais.icone', ['nome' => 'cadeado', 'tamanho' => 12])</span>
            @endif
        </summary>
        <div class="arvore__filhos">
            @foreach ($no->filhos as $filho)
                @include('mesa.parciais.arvore-item', ['no' => $filho, 'campanha' => $campanha, 'cena' => $cena, 'souMestre' => $souMestre])
            @endforeach
        </div>
    </details>
@else
    <a href="{{ $url }}" class="arvore__item {{ $ehCenaAtiva ? 'ativo' : '' }}">
        @if ($ehFicha)
            @php $ehNpc = $item->ficha?->tipo === \App\Enums\TipoFicha::Npc; @endphp
            <span class="ponto {{ $ehNpc ? 'ponto--npc' : '' }}" aria-hidden="true"></span>
            {{ $item->nome }}
            @if ($ehNpc && $item->ficha?->revelada)
                <span class="arvore__fim arvore__fim--ambar">REVELADO</span>
            @elseif (! $ehNpc && $item->dono)
                <span class="arvore__fim" style="font-family: inherit; font-size: 11px">{{ $item->dono->nome }}</span>
            @endif
        @elseif ($ehCena)
            @include('parciais.icone', ['nome' => 'cena', 'tamanho' => 12])
            {{ $item->nome }}
            @if ($ehCenaAtiva) <span class="arvore__fim arvore__fim--ambar">ATIVA</span> @endif
        @else
            @include('parciais.icone', ['nome' => 'documento', 'tamanho' => 14, 'cor' => 'var(--texto-fraco)'])
            {{ $item->nome }}
        @endif
        @if ($oculto && $souMestre && ! $ehCena)
            <span class="arvore__fim">@include('parciais.icone', ['nome' => 'cadeado', 'tamanho' => 12])</span>
        @endif
    </a>
@endif
