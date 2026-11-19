{{--
    Foto do usuário ou silhueta padrão.
    <x-retrato :imagem="$usuario->avatar" tamanho="120" />
--}}
@props(['imagem' => null, 'tamanho' => 76, 'alt' => ''])

@if ($imagem)
    <img src="{{ asset('storage/'.$imagem) }}" alt="{{ $alt }}" width="{{ $tamanho }}" height="{{ $tamanho }}"
         {{ $attributes->class('block shrink-0 border-[1.5px] border-linha object-cover') }}
         style="width: {{ $tamanho }}px; height: {{ $tamanho }}px;">
@else
    <div aria-hidden="true" {{ $attributes->class('flex shrink-0 items-end justify-center overflow-hidden border-[1.5px] border-linha bg-marfim') }}
    style="width: {{ $tamanho }}px; height: {{ $tamanho }}px;">
        <svg width="86%" height="86%" viewBox="0 0 40 40">
            <circle cx="20" cy="15" r="8" fill="#dccdb0"/>
            <path d="M3,40 C3,28 11,24 20,24 C29,24 37,28 37,40 Z" fill="#dccdb0"/>
            <path d="M20 28.5l3 3.5-3 3.5-3-3.5z" fill="#c8962e"/>
        </svg>
    </div>
@endif
