@props(['nome', 'foto' => null, 'tamanho' => 'md', 'forma' => 'redonda'])

@php
    $iniciais = collect(preg_split('/\s+/', trim($nome)))
        ->filter()
        ->map(fn ($parte) => mb_strtoupper(mb_substr($parte, 0, 1)))
        ->pipe(fn ($letras) => $letras->first().($letras->count() > 1 ? $letras->last() : ''));

    [$caixa, $fonte] = match ($tamanho) {
        'xs' => ['size-9', 'text-[13px]'],
        'sm' => ['size-11', 'text-[15px]'],
        'lg' => ['size-24', 'text-[34px]'],
        'xl' => ['size-[120px]', 'text-[40px]'],
        default => ['size-14', 'text-xl'],
    };

    $estilo = $forma === 'quadrada'
        ? 'rounded-[14px] bg-superficie-2 text-ambar-claro'
        : 'rounded-full bg-avatar text-ambar-claro';
@endphp

@if ($foto)
    <img src="{{ $foto }}" alt="" {{ $attributes->class("$caixa shrink-0 object-cover ".($forma === 'quadrada' ? 'rounded-[14px]' : 'rounded-full')) }}>
@else
    <span aria-hidden="true" {{ $attributes->class("$caixa $fonte $estilo flex shrink-0 items-center justify-center font-titulo font-extrabold") }}>{{ $iniciais }}</span>
@endif
