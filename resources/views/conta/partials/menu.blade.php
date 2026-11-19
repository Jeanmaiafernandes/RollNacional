{{-- Menu lateral das páginas da conta. $ativo: 'perfil', 'dados' ou 'senha'. --}}
@php
    $itens = array_filter([
        'perfil' => ['conta.perfil', 'Perfil público'],
        'dados' => ['conta.dados', 'Dados da conta'],
        'senha' => ['conta.senha', 'Senha'],
    ], fn ($item) => Route::has($item[0]));
@endphp

<nav aria-label="Seções da conta" class="flex flex-[1_1_200px] flex-col self-start border-t-2 border-tinta md:sticky md:top-6 md:max-w-[240px]">
    @foreach ($itens as $chave => [$rota, $texto])
        <a href="{{ route($rota) }}"
           @if ($chave === $ativo) aria-current="page" @endif
           class="border-b border-linha px-3 py-3 text-lg no-underline {{ $chave === $ativo ? 'bg-vermelho-claro font-semibold text-tinta shadow-[inset_4px_0_0_var(--color-vermelho)]' : 'text-[#2c2420] hover:bg-marfim hover:text-tinta' }}">{{ $texto }}</a>
    @endforeach
</nav>
