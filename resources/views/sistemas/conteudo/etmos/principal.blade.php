{{-- Etmos: "Para jogar" e "Na RollNacional", lado a lado no computador --}}
<div class="grid items-start gap-6 md:grid-cols-2">
    @include('sistemas.partials.lista', [
        'titulo' => 'Para jogar',
        'itens' => [
            'De três a seis pessoas, contando o narrador.',
            'Dois dados de seis lados.',
            'Uma ficha de Orador por pessoa.',
            'O baralho do Grimório ajuda, mas não é obrigatório.',
        ],
    ])

    @include('sistemas.partials.na-rollnacional', [
        'itens' => [
            'Ficha de Orador com Corpo, Mente e Alma.',
            'Estresse e Ferimentos calculados pelos atributos.',
            'Partículas do Grimório ligadas ao compêndio.',
        ],
    ])
</div>
