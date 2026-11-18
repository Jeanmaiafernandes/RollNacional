@props(['ativo' => 'nenhum'])

@php
    $itens = [
          'painel' => ['Início', route('painel')],
    ];
@endphp

<header class="relative border-b border-borda bg-fundo-profundo">
    <div class="mx-auto box-border flex min-h-16 max-w-7xl flex-wrap items-center gap-x-7 gap-y-3 px-6 py-2.5">
        <x-logo :href="route('painel')" />

        <nav aria-label="Principal" class="flex flex-auto flex-wrap gap-1">
            @foreach ($itens as $chave => [$texto, $url])
                <a href="{{ $url }}"
                   @if ($ativo === $chave) aria-current="page" @endif
                   @class([
                       'flex min-h-11 items-center rounded-lg px-3.5 text-sm no-underline',
                       'bg-superficie-2 font-semibold text-ambar-claro hover:text-ambar-claro' => $ativo === $chave,
                       'font-medium text-texto-2 hover:bg-superficie hover:text-texto' => $ativo !== $chave,
                   ])>{{ $texto }}</a>
            @endforeach
        </nav>

        <div class="flex items-center gap-2.5">

            <button type="button" aria-label="Notificações" class="flex size-11 items-center justify-center rounded-[10px] border border-borda text-texto-2 hover:bg-superficie">
                <x-icone nome="sino" class="size-[18px]" stroke-width="1.8" />
            </button>

            <div class="relative" x-data="{ aberto: false }" x-on:keydown.escape.window="aberto = false" x-on:click.outside="aberto = false">
                <button type="button"
                        x-on:click="aberto = ! aberto"
                        x-bind:aria-expanded="aberto.toString()"
                        aria-expanded="false"
                        aria-haspopup="true"
                        aria-controls="menu-conta"
                        aria-label="Menu da conta de {{ $usuario->nome }}"
                        class="flex h-11 items-center gap-2 rounded-full border border-borda bg-superficie py-0 pl-1 pr-2.5 text-texto">
                    <x-avatar :nome="$usuario->nome" :foto="$usuario->avatar_url" tamanho="xs" />
                    <span class="text-sm font-medium">{{ Str::before($usuario->nome, ' ') }}</span>
                    <x-icone nome="chevron-baixo" class="size-3.5 text-suave" stroke-width="2.2" />
                </button>

                <nav
                    id="menu-conta"
                     aria-label="Menu da conta"
                     x-cloak
                     x-show="aberto"
                     x-transition.origin.top.right
                     class="absolute right-0 top-[calc(100%+8px)] z-40 flex w-72 flex-col rounded-[14px] border border-borda bg-superficie p-2 shadow-[0_18px_40px_rgba(0,0,0,0.45)]">
                    <div class="mb-1.5 flex items-center gap-3 border-b border-borda px-3 pb-3.5 pt-3">
                        <x-avatar :nome="$usuario->nome" :foto="$usuario->avatar_url" tamanho="sm" />
                        <div class="flex min-w-0 flex-col gap-0.5">
                            <span class="text-[15px] font-semibold">{{ $usuario->nome }}</span>
                            <span class="text-[13px] text-suave">{{ '@'.$usuario->nome_usuario }}</span>
                        </div>
                    </div>

                    <div class="mx-1 my-1.5 h-px bg-borda" aria-hidden="true"></div>

                    <form method="POST" action="{{ route('sair') }}">
                        @csrf
                        <button type="submit" class="flex min-h-11 w-full items-center gap-3 rounded-lg px-3 text-left text-sm text-perigo hover:bg-superficie-2">
                            <x-icone nome="sair" class="size-[18px]" stroke-width="1.8" />
                            Sair
                        </button>
                    </form>
                </nav>
            </div>
        </div>
    </div>
</header>
