@extends('layouts.visitante')

@section('titulo', 'Criar conta')

@section('conteudo')
    <h2 class="font-titulo text-3xl font-bold">Nova conta</h2>

    <form method="POST" action="{{ route('cadastrar') }}" class="mt-7 flex flex-col gap-4">
        @csrf

        {{-- Cada campo é uma caixa de ficha: rótulo pequeno em cima, valor embaixo --}}
        @foreach ([
            ['nome', 'Nome', 'text', 'name'],
            ['email', 'E-mail', 'email', 'email'],
        ] as [$campo, $rotulo, $tipo, $autocomplete])
            <div>
                <label @class([
                    'block border bg-fundo px-3.5 pb-2 pt-2.5 focus-within:border-ambar',
                    'border-tormenta' => $errors->has($campo),
                    'border-borda-forte' => ! $errors->has($campo),
                ])>
                    <span class="block text-[11px] font-semibold uppercase tracking-[0.14em] text-suave">{{ $rotulo }}</span>
                    <input type="{{ $tipo }}" name="{{ $campo }}" value="{{ old($campo) }}" required autocomplete="{{ $autocomplete }}" @if ($loop->first) autofocus @endif
                    class="mt-1 w-full border-0 bg-transparent p-0 text-[15px] text-texto outline-none">
                </label>
                @error($campo)
                <p class="mt-1.5 text-sm text-erro-texto">{{ $message }}</p>
                @enderror
            </div>
        @endforeach

        <div>
            <div class="grid grid-cols-2">
                <label @class([
                    'relative block border bg-fundo px-3.5 pb-2 pt-2.5 focus-within:z-10 focus-within:border-ambar',
                    'z-10 border-tormenta' => $errors->has('password'),
                    'border-borda-forte' => ! $errors->has('password'),
                ])>
                    <span class="block text-[11px] font-semibold uppercase tracking-[0.14em] text-suave">Senha</span>
                    <input id="senha" name="senha" type="password" required autocomplete="new-password"
                           class="mt-1 w-full border-0 bg-transparent p-0 text-[15px] text-texto outline-none">
                </label>
                <label class="relative -ml-px block border border-borda-forte bg-fundo px-3.5 pb-2 pt-2.5 focus-within:z-10 focus-within:border-ambar">
                    <span class="block text-[11px] font-semibold uppercase tracking-[0.14em] text-suave">Confirmar</span>
                    <input type="password" id="senha_confirmation" name="senha_confirmation" required autocomplete="new-password"
                           class="mt-1 w-full border-0 bg-transparent p-0 text-[15px] text-texto outline-none">
                </label>
            </div>
            @error('password')
            <p class="mt-1.5 text-sm text-erro-texto">{{ $message }}</p>
            @else
                <p class="mt-1.5 text-xs text-suave">Mínimo de 8 caracteres.</p>
                @enderror
        </div>

        <button type="submit" class="mt-2 h-12 cursor-pointer bg-ambar text-sm font-bold uppercase tracking-[0.14em] text-sobre-ambar hover:bg-ambar-claro">
            Criar conta
        </button>
    </form>
@endsection
