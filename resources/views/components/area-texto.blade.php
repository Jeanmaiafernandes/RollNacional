@props(['nome', 'rotulo', 'valor' => null, 'id' => null, 'maximo' => null, 'dica' => null])

@php
    $id ??= $nome;
    $temErro = $errors->has($nome);
    $texto = old($nome, $valor) ?? '';
@endphp

<div class="flex flex-col gap-2" @if ($maximo) x-data="{ tamanho: {{ mb_strlen($texto) }} }" @endif>
    <div class="flex items-baseline justify-between">
        <label for="{{ $id }}" class="rn-rotulo">{{ $rotulo }}</label>
        @if ($maximo)
            <span class="text-[13px] text-suave"><span x-text="tamanho">{{ mb_strlen($texto) }}</span> / {{ $maximo }}</span>
        @endif
    </div>

    <textarea
        id="{{ $id }}"
        name="{{ $nome }}"
        @if ($maximo) maxlength="{{ $maximo }}" x-on:input="tamanho = $event.target.value.length" @endif
        @if ($dica) aria-describedby="{{ $id }}-dica" @endif
        @if ($temErro) aria-invalid="true" @endif
        {{ $attributes->class(['w-full resize-y rounded-[10px] border bg-fundo px-3.5 py-3 text-[15px] leading-relaxed text-texto', 'border-tormenta' => $temErro, 'border-borda-forte' => ! $temErro]) }}
    >{{ $texto }}</textarea>

    @if ($dica)
        <p id="{{ $id }}-dica" class="text-[13px] text-suave">{{ $dica }}</p>
    @endif

    @error($nome)
        <p class="text-[13px] text-erro-texto">{{ $message }}</p>
    @enderror
</div>
