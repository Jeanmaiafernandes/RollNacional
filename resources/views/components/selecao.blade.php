@props(['nome', 'rotulo', 'opcoes' => [], 'valor' => null, 'id' => null, 'vazio' => 'Selecione…', 'compacto' => false])

@php
    $id ??= $nome;
    $selecionado = (string) old($nome, $valor);
    $opcoes = array_is_list($opcoes) ? array_combine($opcoes, $opcoes) : $opcoes;
@endphp

<div @class(['flex gap-2', 'items-center' => $compacto, 'flex-col' => ! $compacto])>
    <label for="{{ $id }}" @class(['text-sm', 'text-suave' => $compacto, 'font-medium text-texto' => ! $compacto])>{{ $rotulo }}</label>
    <select id="{{ $id }}" name="{{ $nome }}" {{ $attributes->class([
        'rounded-[10px] border border-borda-forte text-texto',
        'h-11 bg-superficie px-3 text-sm' => $compacto,
        'h-12 w-full bg-fundo px-3 text-[15px]' => ! $compacto,
    ]) }}>
        @if ($vazio && ! $compacto)
            <option value="">{{ $vazio }}</option>
        @endif
        @foreach ($opcoes as $chave => $texto)
            <option value="{{ $chave }}" @selected($selecionado === (string) $chave)>{{ $texto }}</option>
        @endforeach
    </select>
    @error($nome)
        <p class="text-[13px] text-erro-texto">{{ $message }}</p>
    @enderror
</div>
