{{-- Tormenta20: "Para jogar" e "Na RollNacional", lado a lado no computador --}}
<div class="grid items-start gap-6 md:grid-cols-2">
    @include('sistemas.partials.lista', [
        'titulo' => 'Para jogar',
        'itens' => [
            'De três a seis pessoas, uma delas como mestre.',
            'Um d20 e alguns dados de dano.',
            'Uma ficha por personagem.',
            'O livro básico, ou o compêndio daqui.',
        ],
    ])

    @include('sistemas.partials.na-rollnacional', [
        'itens' => [
            'Atributos, perícias e defesa recalculados a cada mudança.',
            'PV e PM acompanhados direto na ficha.',
            'Classes e poderes ligados ao compêndio.',
        ],
    ])
</div>
