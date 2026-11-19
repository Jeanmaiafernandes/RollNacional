@extends('layouts.visitante')

@section('titulo', 'Entrar')
@section('capitulo', 'Entrada')
@section('imagem', asset('img/site/aventureiros.webp'))
@section('legenda', 'A jornada continua')
@section('frase', 'A mesa estava esperando por você')

@section('conteudo')
    <div class="flex flex-col gap-2.5">
        <h1 class="barras text-5xl">Entrar</h1>
        <p class="text-lg text-tinta-2">Suas fichas continuam onde você deixou.</p>
    </div>

    @include('layouts.partials.avisos')

    @if ($errors->any() && ! $errors->hasAny(['email', 'senha']))
        <div role="alert" class="aviso aviso-erro">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('entrar') }}" class="flex flex-col gap-5" novalidate>
        @csrf

        <x-campo nome="email" rotulo="E-mail" tipo="email" :valor="old('email')" autocomplete="email" placeholder="voce@exemplo.com" required autofocus />
        <x-campo nome="senha" rotulo="Senha" tipo="password" autocomplete="current-password" required />

        <label class="flex cursor-pointer items-center gap-2.5 text-[17px] text-tinta-2">
            <input type="checkbox" name="lembrar" value="1" @checked(old('lembrar')) class="m-0 size-5 accent-vermelho">
            Manter conectado neste aparelho
        </label>

        <button type="submit" class="btn h-14 text-lg">Entrar na mesa</button>
    </form>

    <p class="border-t border-dotted border-pontilhado pt-4 text-[17px] text-tinta-2">
        Primeira vez por aqui? <a href="{{ route('registrar') }}" class="font-semibold">Criar conta</a>
    </p>
@endsection
