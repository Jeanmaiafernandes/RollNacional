{{-- Lista com losango vermelho. Uso: @include('sistemas.partials.lista', ['titulo' => '...', 'itens' => [...]]) --}}
<section class="flex flex-col">
    <h2 class="flex items-center gap-2.5 border-b-2 border-tinta pb-2 text-xl">
        {{ $titulo }}
        @include('sistemas.partials.marca')
    </h2>
    <ul class="text-[15px]">
        @foreach ($itens as $item)
            <li class="flex items-baseline gap-3 border-b border-linha py-2.5">
                <span aria-hidden="true" class="size-2 shrink-0 -translate-y-px rotate-45 bg-vermelho"></span>
                <span>{{ $item }}</span>
            </li>
        @endforeach
    </ul>
</section>
