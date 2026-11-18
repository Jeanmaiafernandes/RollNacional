@extends('layouts.visitante')

@section('titulo', 'Entrar')

@section('conteudo')
    <h2 class="font-titulo text-3xl font-bold">Bem-vindo de volta</h2>
    <p class="mt-1.5 text-sm text-suave">Entre para continuar suas fichas.</p>

    <form method="POST" action="{{ route('entrar') }}" class="mt-7 flex flex-col gap-4">
        @csrf

        {{-- Cada campo é uma caixa de ficha: rótulo pequeno em cima, valor embaixo --}}
        <div>
            <label @class([
                'block border bg-fundo px-3.5 pb-2 pt-2.5 focus-within:border-ambar',
                'border-tormenta' => $errors->has('email'),
                'border-borda-forte' => ! $errors->has('email'),
            ])>
                <span class="block text-[11px] font-semibold uppercase tracking-[0.14em] text-suave">E-mail</span>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                       class="mt-1 w-full border-0 bg-transparent p-0 text-[15px] text-texto outline-none">
            </label>
            @error('email')
            <p class="mt-1.5 text-sm text-erro-texto">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label @class([
                'block border bg-fundo px-3.5 pb-2 pt-2.5 focus-within:border-ambar',
                'border-tormenta' => $errors->has('password'),
                'border-borda-forte' => ! $errors->has('password'),
            ])>
                <span class="block text-[11px] font-semibold uppercase tracking-[0.14em] text-suave">Senha</span>
                <input id="senha" name="senha" type="password" required autocomplete="current-password"
                       class="mt-1 w-full border-0 bg-transparent p-0 text-[15px] text-texto outline-none">
            </label>
            @error('password')
            <p class="mt-1.5 text-sm text-erro-texto">{{ $message }}</p>
            @enderror
        </div>

        <label class="flex cursor-pointer items-center gap-2.5 py-1 text-sm text-texto-2">
            <input type="checkbox" name="lembrar" value="1" @checked(old('lembrar')) class="size-4 accent-ambar">
            Manter conectado neste dispositivo
        </label>

        <button type="submit" class="mt-2 h-12 cursor-pointer bg-ambar text-sm font-bold uppercase tracking-[0.14em] text-sobre-ambar hover:bg-ambar-claro">
            Entrar na mesa
        </button>
    </form>
@endsection
