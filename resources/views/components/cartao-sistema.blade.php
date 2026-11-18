
@props(['sistema'])

<article {{ $attributes->class('rn-cartao flex flex-col overflow-hidden') }}>
    <div @class(['h-1.5', 'bg-tormenta' => $sistema->cor === 'tormenta', 'bg-dnd' => $sistema->cor === 'dnd']) aria-hidden="true"></div>

    <div class="flex flex-auto flex-col gap-4.5 p-6.5">
        <div class="flex items-center gap-4">
            <span @class([
                'flex size-16 shrink-0 items-center justify-center rounded-[14px] font-titulo text-[22px] font-extrabold',
                'bg-tormenta-fundo text-tormenta-texto' => $sistema->cor === 'tormenta',
                'bg-dnd-fundo text-dnd-texto' => $sistema->cor === 'dnd',
            ]) aria-hidden="true">{{ $sistema->sigla }}</span>
            <div class="flex flex-col gap-1.5">
                <h2 class="font-titulo text-[26px] font-bold">{{ $sistema->nome }}</h2>
                <div class="flex flex-wrap gap-1.5">
                    <x-etiqueta-sistema :cor="$sistema->origem === 'nacional' ? 'ambar' : $sistema->cor">{{ ucfirst($sistema->origem) }}</x-etiqueta-sistema>
                    <x-etiqueta-sistema>{{ $sistema->genero }}</x-etiqueta-sistema>
                    <x-etiqueta-sistema>{{ $sistema->editora }}</x-etiqueta-sistema>
                </div>
            </div>
        </div>

        <p class="text-[15px] leading-relaxed text-texto-2">{{ $sistema->descricao }}</p>

        <dl class="grid grid-cols-2 gap-3">
            <x-ficha.estatistica rotulo="Modelo de ficha" valor="Personagem e criatura" />
            <x-ficha.estatistica rotulo="Licença do compêndio" :valor="$sistema->licenca" />
        </dl>

        <div class="mt-auto flex flex-wrap gap-2.5 pt-1">
            <x-botao variante="secundario" :href="route('sistemas.compendio', $sistema->slug)">Ver sistema e compêndio</x-botao>
            <x-botao :href="route('personagens.create', ['sistema' => $sistema->slug])">Criar ficha</x-botao>
        </div>
    </div>
</article>
