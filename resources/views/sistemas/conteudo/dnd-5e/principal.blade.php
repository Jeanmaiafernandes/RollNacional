{{-- D&D 5e: "Para jogar" e "Na RollNacional", lado a lado no computador --}}
<div class="grid items-start gap-6 md:grid-cols-2">
    @include('sistemas.partials.lista', [
        'titulo' => 'Para jogar',
        'itens' => [
            'De três a seis pessoas, uma delas como mestre.',
            'Um conjunto de dados, do d4 ao d20.',
            'Uma ficha por personagem.',
            'O Livro do Jogador, ou as regras básicas gratuitas.',
        ],
    ])

    @include('sistemas.partials.na-rollnacional', [
        'itens' => [
            'Modificadores, salvaguardas e proficiências calculados.',
            'Espaços de magia para marcar durante a sessão.',
            'Perícias ligadas aos atributos da ficha.',
        ],
    ])
</div>
