@extends('layouts.visitante')

@section('titulo', 'Criar conta')
@section('capitulo', 'Primeira sessão')
@section('imagem', asset('img/site/castelo.webp'))
@section('legenda', 'O reino à vista')
@section('frase', 'Toda campanha começa com uma ficha')

@section('conteudo')
    <div class="flex flex-col gap-2.5">
        <h1 class="barras text-5xl">Criar conta</h1>
        <p class="text-lg text-tinta-2">Só o necessário para guardar suas fichas.</p>
    </div>

    @if ($errors->any() && ! $errors->hasAny(['nome', 'nome_usuario', 'email', 'senha']))
        <div role="alert" class="aviso aviso-erro">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('registrar') }}" class="flex flex-col gap-[18px]" novalidate>
        @csrf

        <x-campo nome="nome" rotulo="Nome" :valor="old('nome')" autocomplete="name" required autofocus />
        <x-campo nome="nome_usuario" rotulo="Nome de usuário" :valor="old('nome_usuario')" autocomplete="username"
                 dica="Aparece no endereço do seu perfil público. Letras minúsculas, números e traço." required />
        <x-campo nome="email" rotulo="E-mail" tipo="email" :valor="old('email')" autocomplete="email" required />

        <div class="grid items-start gap-4 sm:grid-cols-2">
            <x-campo nome="senha" rotulo="Senha" tipo="password" autocomplete="new-password" required />
            <x-campo nome="senha_confirmation" rotulo="Confirmar senha" tipo="password" autocomplete="new-password" required />
        </div>

        <button type="submit" class="btn mt-1 h-14 w-full text-lg">Criar conta</button>
    </form>

    <p class="border-t border-dotted border-pontilhado pt-4 text-[17px] text-tinta-2">
        Já tem conta? <a href="{{ route('entrar') }}" class="font-semibold">Entrar</a>
    </p>
@endsection
