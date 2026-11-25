@extends('layouts.app')

@section('titulo', 'Dados da conta')
@section('trilha', 'Minha conta · Dados da conta')

@section('faixa')
    @include('conta.partials.faixa', ['titulo' => 'Dados da conta'])
@endsection

@section('conteudo')
    <div class="flex flex-wrap items-start gap-10">
        @include('conta.partials.menu', ['ativo' => 'dados'])

        <div class="flex min-w-0 flex-[999_1_560px] flex-col gap-8">
            {{-- E-mail --}}
            <form method="POST" action="{{ route('conta.email') }}" class="cartao flex flex-col gap-5" novalidate>
                @csrf
                @method('PUT')

                <div class="flex flex-col gap-2">
                    <h2 class="barras text-3xl">E-mail</h2>
                    <p class="text-[17px] text-tinta-2">Usado para entrar. Não aparece para outros jogadores.</p>
                </div>

                <div class="max-w-[520px]">
                    <x-campo nome="email" rotulo="E-mail" tipo="email" :valor="old('email', $usuario->email)" autocomplete="email" required />
                </div>

                <div class="flex justify-end border-t border-dotted border-pontilhado pt-4">
                    <button type="submit" class="btn">Salvar e-mail</button>
                </div>
            </form>

            {{-- Sobre a conta --}}
            <section class="cartao flex flex-col gap-5" style="--faixa: var(--color-dourado)">
                <h2 class="barras text-3xl">Sobre a conta</h2>
                <ul class="border-t-2 border-tinta">
                    <li class="flex items-baseline gap-3 border-b border-linha py-3">
                        <span class="rotulo">Nome de usuário</span>
                        <span class="pontilhado" aria-hidden="true"></span>
                        <span class="text-right text-lg">
                            {{ '@'.$usuario->nome_usuario }}
                            @if (Route::has('conta.perfil'))
                                · <a href="{{ route('conta.perfil') }}">alterar no perfil</a>
                            @endif
                        </span>
                    </li>
                    <li class="flex items-baseline gap-3 border-b border-linha py-3">
                        <span class="rotulo">Conta criada em</span>
                        <span class="pontilhado" aria-hidden="true"></span>
                        <span class="text-right text-lg">{{ $usuario->criado_em?->translatedFormat('j \d\e F \d\e Y') }}</span>
                    </li>
                    <li class="flex items-baseline gap-3 border-b border-linha py-3">
                        <span class="rotulo">Senha</span>
                        <span class="pontilhado" aria-hidden="true"></span>
                        <span class="text-right text-lg">•••••••• · <a href="{{ route('conta.senha') }}">trocar</a></span>
                    </li>
                </ul>
            </section>

            {{-- Sessão --}}
            <section class="cartao flex flex-col gap-5" style="--faixa: var(--color-tinta)">
                <h2 class="barras text-3xl">Sessão</h2>
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <p class="max-w-[520px] text-[17px] leading-relaxed text-tinta-2">Você está conectado neste aparelho. Sair encerra a sessão só aqui.</p>
                    @if (Route::has('sair'))
                        <form method="POST" action="{{ route('sair') }}">
                            @csrf
                            <button type="submit" class="btn-sec">Sair da conta</button>
                        </form>
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection
