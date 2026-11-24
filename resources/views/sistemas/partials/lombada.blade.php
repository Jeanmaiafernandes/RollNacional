{{-- Lombada de livro com a cor e a sigla do sistema --}}
<span aria-hidden="true" class="flex h-[100px] w-[52px] shrink-0 flex-col items-center justify-between border-2 border-tinta py-2.5 text-dourado-claro" style="background: {{ $sistema->cor }}">
    <span class="h-0.5 w-3/5 bg-current"></span>
    <span class="rotate-180 font-rotulo text-lg font-bold tracking-[0.1em] [writing-mode:vertical-rl]">{{ $sistema->sigla }}</span>
    <span class="h-0.5 w-3/5 bg-current"></span>
</span>
