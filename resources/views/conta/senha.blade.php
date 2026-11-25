@extends('layouts.app')

@section('titulo', 'Senha')
@section('trilha', 'Minha conta · Senha')

@section('faixa')
    @include('conta.partials.faixa', ['titulo' => 'Senha'])
@endsection

@section('conteudo')
    <div class="flex flex-wrap items-start gap-10" x-data="{ visivel: false }">
        @include('conta.partials.menu', ['ativo' => 'senha'])

        <form method="POST" action="{{ route('conta.senha.atualizar') }}" class="cartao flex min-w-0 flex-[999_1_520px] flex-col gap-5" style="--faixa: var(--color-dourado)" novalidate>
            @csrf
            @method('PUT')

            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="barras text-3xl">Trocar senha</h2>
                <button type="button" class="btn-sec h-9 px-3.5 text-[13px]" x-on:click="visivel = ! visivel"
                        x-bind:aria-pressed="visivel" x-text="visivel ? 'Ocultar senhas' : 'Mostrar senhas'">Mostrar senhas</button>
            </div>
            <p class="-mt-1.5 text-[17px] text-tinta-2">Confirme a senha atual e escolha uma nova.</p>

            <x-campo nome="senha_atual" rotulo="Senha atual" tipo="password" autocomplete="current-password" x-bind:type="visivel ? 'text' : 'password'" required />

            <div class="grid items-start gap-[18px] sm:grid-cols-2">
                <x-campo nome="senha" rotulo="Nova senha" tipo="password" autocomplete="new-password" x-bind:type="visivel ? 'text' : 'password'" required />
                <x-campo nome="senha_confirmation" rotulo="Confirmar nova senha" tipo="password" autocomplete="new-password" x-bind:type="visivel ? 'text' : 'password'" required />
            </div>

            <div class="border border-linha bg-marfim px-[18px] py-4">
                <p class="sobrelinha mb-2.5 text-xs">A nova senha precisa</p>
                <ul class="flex flex-col gap-1.5 text-[17px] text-[#2c2420]">
                    @foreach (['ter pelo menos 8 caracteres;', 'ser diferente da senha atual;', 'ser igual nos dois campos.'] as $requisito)
                        <li class="flex items-baseline gap-2.5">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="#a8191f" aria-hidden="true"><path d="M12 2l9 10-9 10-9-10z"/></svg>
                            {{ $requisito }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex justify-end border-t border-dotted border-pontilhado pt-4">
                <button type="submit" class="btn">Trocar senha</button>
            </div>
        </form>

        <aside class="flex flex-[1_1_260px] flex-col gap-7 pt-3.5 md:max-w-[320px]">
            <div class="bilhete -rotate-[1.5deg]">
                <span class="fita" aria-hidden="true"></span>
                <p class="rotulo mb-1.5 text-xs text-vermelho">Outros aparelhos</p>
                <p>Ao trocar a senha, as sessões abertas em outros aparelhos são encerradas. Aqui você continua conectado.</p>
            </div>
            <div class="bilhete rotate-[1.2deg]">
                <span class="fita fita-vermelha" aria-hidden="true"></span>
                <p class="rotulo mb-1.5 text-xs text-vermelho">Dica</p>
                <p>Uma frase com três ou quatro palavras costuma ser mais forte e mais fácil de lembrar.</p>
            </div>
        </aside>
    </div>
@endsection
