{{-- Quadro vermelho com o que a ficha da RollNacional faz neste sistema.
     Uso: @include('sistemas.partials.na-rollnacional', ['itens' => [...]]) --}}
<section aria-labelledby="na-rollnacional" class="flex flex-col gap-3 bg-vermelho p-5 text-[#fbf1e1]">
    <div class="flex flex-wrap items-center gap-2.5">
        <h2 id="na-rollnacional" class="font-rotulo text-[15px] font-semibold uppercase tracking-[0.14em] text-[#fbf1e1]">Na RollNacional</h2>
        @if ($sistema->situacao_ficha)
            <span class="border border-dourado-claro px-2 font-rotulo text-[10px] font-semibold uppercase tracking-[0.14em] text-dourado-claro">{{ $sistema->situacao_ficha }}</span>
        @endif
    </div>
    <ul class="flex flex-col gap-2.5 text-[15px]">
        @foreach ($itens as $item)
            <li class="flex items-baseline gap-3">
                <span aria-hidden="true" class="size-[7px] shrink-0 rotate-45 bg-dourado-claro"></span>
                <span>{{ $item }}</span>
            </li>
        @endforeach
    </ul>
</section>
