
@props(['personagem', 'compacto' => false])

@if ($compacto)
    <a href="{{ $personagem->url }}" {{ $attributes->class('rn-cartao flex flex-col gap-4 rounded-[14px] p-5 text-texto no-underline hover:border-borda-forte hover:text-texto') }}>
        <div class="flex items-center justify-between gap-2">
            <x-avatar :nome="$personagem->nome" forma="quadrada" tamanho="sm" />
            <x-etiqueta-sistema :cor="$personagem->sistema->cor">{{ $personagem->sistema->nome }}</x-etiqueta-sistema>
        </div>
        <div class="flex flex-col gap-1">
            <span class="text-[17px] font-semibold">{{ $personagem->nome }}</span>
            <span class="text-sm text-suave">{{ $personagem->resumo }}</span>
        </div>
        <div class="flex flex-col gap-1.5">
            <div class="flex justify-between text-[13px] text-suave"><span>PV</span><span>{{ $personagem->pv_atual }} / {{ $personagem->pv_max }}</span></div>
            <span class="h-1.5 overflow-hidden rounded-full bg-[#2a2e35]" aria-hidden="true">
                <span class="block h-full bg-sucesso" style="width: {{ round($personagem->pv_atual / max(1, $personagem->pv_max) * 100) }}%"></span>
            </span>
        </div>
        <span class="text-[13px] text-suave">
            {{ $personagem->rascunho ? 'Rascunho · ' : 'Atualizada ' }}{{ $personagem->atualizado_em->diffForHumans() }}
        </span>
    </a>
@else
    <article {{ $attributes->class('rn-cartao flex flex-col overflow-hidden') }}>
        <div class="flex flex-col gap-4 p-5">
            <div class="flex items-center gap-3.5">
                <x-avatar :nome="$personagem->nome" forma="quadrada" />
                <div class="flex min-w-0 flex-1 flex-col gap-1">
                    <h2 class="text-[17px] font-semibold">{{ $personagem->nome }}</h2>
                    <span class="text-sm text-suave">{{ $personagem->resumo }}</span>
                </div>
                <div class="relative" x-data="{ aberto: false }" x-on:click.outside="aberto = false" x-on:keydown.escape="aberto = false">
                    <button type="button" x-on:click="aberto = ! aberto" x-bind:aria-expanded="aberto.toString()" aria-expanded="false"
                            aria-label="Mais ações para {{ $personagem->nome }}"
                            class="flex size-11 items-center justify-center rounded-[10px] text-suave hover:bg-superficie-2">
                        <x-icone nome="reticencias" class="size-[18px]" stroke-width="2.6" />
                    </button>
                    <div x-cloak x-show="aberto" x-transition class="absolute right-0 top-12 z-30 flex w-48 flex-col rounded-xl border border-borda bg-superficie p-1.5 shadow-[0_12px_30px_rgba(0,0,0,0.45)]">
                        <button type="button" class="min-h-10 rounded-lg px-3 text-left text-sm hover:bg-superficie-2">Duplicar</button>
                        <button type="button" class="min-h-10 rounded-lg px-3 text-left text-sm hover:bg-superficie-2">Exportar JSON</button>
                        <button type="button" class="min-h-10 rounded-lg px-3 text-left text-sm text-perigo hover:bg-superficie-2">Excluir</button>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-1.5">
                <x-etiqueta-sistema :cor="$personagem->sistema->cor">{{ $personagem->sistema->nome }}</x-etiqueta-sistema>
                <x-etiqueta-sistema>{{ $personagem->publica ? 'Pública' : 'Privada' }}</x-etiqueta-sistema>
                @if ($personagem->rascunho)
                    <x-etiqueta-sistema cor="ambar">Rascunho</x-etiqueta-sistema>
                @endif
            </div>

            <dl class="grid grid-cols-3 gap-2">
                @foreach ($personagem->destaques as [$rotulo, $valor])
                    <div class="rounded-[10px] bg-recuo p-2.5 text-center">
                        <dt class="text-xs text-suave">{{ $rotulo }}</dt>
                        <dd class="mt-0.5 text-base font-bold">{{ $valor }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>

        <div class="mt-auto flex items-center justify-between gap-2.5 border-t border-borda px-5 py-3">
            <span class="text-[13px] text-suave">{{ ucfirst($personagem->atualizado_em->diffForHumans()) }}</span>
            <x-botao variante="secundario" tamanho="sm" :href="$personagem->url">Abrir ficha</x-botao>
        </div>
    </article>
@endif
