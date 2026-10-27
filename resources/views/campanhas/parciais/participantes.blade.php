{{--
    Tabela de participantes. Os <form> ficam FORA da tabela e os controles apontam
    para eles pelo atributo form="..." (HTML não permite form dentro de <tr>).
    Rotas: campanhas.participantes.atualizar (PUT campanha, usuario) e .expulsar (DELETE).
    A ficha do jogador na mesa, quando existir: $membro->pivot->ficha (etapa 4) — opcional.
--}}
@php
    $podeGerir = auth()->user()->can('gerirParticipantes', $campanha);
    $papeis = \App\Enums\PapelCampanha::valoresAtribuiveis();
@endphp

@if ($podeGerir)
    @foreach ($campanha->membros as $membro)
        @continue($membro->pivot->papel === \App\Enums\PapelCampanha::Mestre)
        <form id="papel-{{ $membro->id }}" method="POST" action="{{ route('campanhas.participantes.atualizar', [$campanha, $membro]) }}">
            @csrf @method('PATCH')
        </form>
        <form id="expulsar-{{ $membro->id }}" method="POST" action="{{ route('campanhas.participantes.expulsar', [$campanha, $membro]) }}"
              onsubmit="return confirm('Expulsar {{ $membro->nome }} da campanha?')">
            @csrf @method('DELETE')
        </form>
    @endforeach
@endif

<div class="rolagem-x">
    <table class="tabela">
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Papel</th>
                <th>Pode criar itens</th>
                <th>Ficha na mesa</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($campanha->membros as $membro)
                @php
                    $papel = $membro->pivot->papel;
                    $ehMestre = $papel === \App\Enums\PapelCampanha::Mestre;
                    $ehEspectador = $papel === \App\Enums\PapelCampanha::Espectador;
                    $recemChegado = $ehEspectador && $membro->pivot->created_at?->isToday();
                @endphp
                <tr>
                    <td>
                        <strong>{{ $membro->nome }}</strong>
                        @if ($membro->id === auth()->id()) <span class="apagado">(você)</span> @endif
                    </td>
                    <td>
                        @if ($ehMestre || ! $podeGerir)
                            @include('parciais.selo-papel', ['papel' => $papel])
                        @else
                            <select name="papel" form="papel-{{ $membro->id }}" aria-label="Papel de {{ $membro->nome }}"
                                    class="selecao selecao--mini" style="width: auto; {{ $recemChegado ? 'border-color: var(--ambar)' : '' }}"
                                    onchange="this.form.submit()">
                                @foreach ($papeis as $opcao)
                                    <option value="{{ $opcao->value }}" @selected($opcao === $papel)>{{ $opcao->rotulo() }}</option>
                                @endforeach
                            </select>
                        @endif
                    </td>
                    <td>
                        @if ($ehMestre || $papel === \App\Enums\PapelCampanha::CoMestre)
                            <span class="apagado">—</span>
                        @elseif ($podeGerir)
                            <label class="marcar">
                                <input type="hidden" name="pode_criar_itens" value="0" form="papel-{{ $membro->id }}">
                                <input type="checkbox" name="pode_criar_itens" value="1" form="papel-{{ $membro->id }}" class="caixa"
                                       @checked($membro->pivot->pode_criar_itens) onchange="this.form.submit()">
                                {{ $membro->pivot->pode_criar_itens ? 'Sim' : 'Não' }}
                            </label>
                        @else
                            {{ $membro->pivot->pode_criar_itens ? 'Sim' : 'Não' }}
                        @endif
                    </td>
                    <td>
                        @if ($recemChegado)
                            <span style="color: var(--ambar); font-size: 13px">Entrou hoje · aguardando papel</span>
                        @elseif (isset($membro->ficha_na_mesa) && Route::has('fichas.exibir'))
                            <a href="{{ route('fichas.exibir', $membro->ficha_na_mesa) }}">{{ $membro->ficha_na_mesa->item->nome }}</a>
                        @else
                            <span class="apagado">—</span>
                        @endif
                    </td>
                    <td class="direita">
                        @if ($podeGerir && ! $ehMestre)
                            <button type="submit" form="expulsar-{{ $membro->id }}" class="botao botao--discreto botao--mini">Expulsar</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
