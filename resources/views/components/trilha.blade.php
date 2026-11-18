@props(['itens' => []])

<nav aria-label="Trilha" {{ $attributes->class('flex flex-wrap items-center gap-2 text-sm text-suave') }}>
    @foreach ($itens as $texto => $url)
        @if (! $loop->first)
            <x-icone nome="chevron-direita" class="size-3.5" />
        @endif
        @if ($url && ! $loop->last)
            <a href="{{ $url }}">{{ $texto }}</a>
        @else
            <span aria-current="page" class="text-texto">{{ $texto }}</span>
        @endif
    @endforeach
</nav>
