{{--
    Campo de formulário com rótulo, erro de validação e dica.
    <x-campo nome="email" rotulo="E-mail" tipo="email" :valor="old('email')" autocomplete="email" />
    tipo="textarea" vira <textarea>.
--}}
@props([
    'nome',
    'rotulo',
    'tipo' => 'text',
    'valor' => null,
    'dica' => null,
    'id' => null,
])

@php
    $id ??= str_replace(['[', ']'], ['_', ''], $nome);
    $erro = $errors->first($nome);
    $descricao = $erro ? $id.'-erro' : ($dica ? $id.'-dica' : null);
@endphp

<div class="flex flex-col gap-2">
    <label for="{{ $id }}" class="rotulo">{{ $rotulo }}</label>

    @if ($tipo === 'textarea')
        <textarea id="{{ $id }}" name="{{ $nome }}"
                  @if ($erro) aria-invalid="true" @endif
                  @if ($descricao) aria-describedby="{{ $descricao }}" @endif
            {{ $attributes->class('entrada') }}>{{ $valor }}</textarea>
    @else
        <input id="{{ $id }}" name="{{ $nome }}" type="{{ $tipo }}"
               @if (! is_null($valor) && $tipo !== 'password') value="{{ $valor }}" @endif
               @if ($erro) aria-invalid="true" @endif
               @if ($descricao) aria-describedby="{{ $descricao }}" @endif
            {{ $attributes->class('entrada') }}>
    @endif

    @if ($erro)
        <p id="{{ $id }}-erro" class="erro">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v6M12 16.5v.5"/></svg>
            {{ $erro }}
        </p>
    @elseif ($dica)
        <p id="{{ $id }}-dica" class="dica">{{ $dica }}</p>
    @endif
</div>
