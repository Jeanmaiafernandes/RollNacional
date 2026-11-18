<x-layouts::app titulo="Minha conta">
    {{-- Cabeçalho da conta --}}
    <section class="flex flex-wrap items-center gap-5">
        <x-avatar :nome="$perfil->nome" :foto="$perfil->avatar_url" tamanho="lg" />
        <div class="flex flex-col gap-1">
            <h1 class="font-titulo text-3xl font-extrabold">{{ $perfil->nome }}</h1>
            <p class="text-sm text-suave">{{ $perfil->email }}</p>
        </div>
    </section>

    <div class="flex flex-wrap items-start gap-8">
        {{-- Navegação entre as seções --}}
        <nav aria-label="Seções da conta" class="flex flex-[1_1_200px] flex-col gap-1 md:max-w-[240px] md:sticky md:top-6">
            <a href="#dados" class="rounded-lg px-4 py-3 text-sm font-medium text-texto-2 no-underline hover:bg-superficie hover:text-texto">Dados da conta</a>
            <a href="#senha" class="rounded-lg px-4 py-3 text-sm font-medium text-texto-2 no-underline hover:bg-superficie hover:text-texto">Senha</a>
        </nav>

        <div class="flex min-w-0 flex-[999_1_560px] flex-col gap-6">
            {{-- Dados da conta --}}
            <section id="dados" class="scroll-mt-6 rounded-2xl border border-borda bg-superficie">
                <div class="border-b border-borda px-6 py-5">
                    <h2 class="text-lg font-semibold">Dados da conta</h2>
                    <p class="mt-1 text-sm text-suave">Nome exibido para outros jogadores e e-mail usado para entrar.</p>
                </div>

                <form method="POST" action="{{ route('conta.atualizar') }}">
                    @csrf
                    @method('PATCH')

                    <div class="grid gap-5 px-6 py-6 md:grid-cols-2">
                        <div class="flex flex-col gap-2">
                            <label for="nome" class="text-sm font-medium">Nome</label>
                            <input id="nome" type="text" name="nome" value="{{ old('nome', $perfil->nome) }}" required autocomplete="name"
                                   class="h-11 rounded-lg border border-borda-forte bg-fundo px-3 text-texto">
                            @error('nome')
                            <p class="text-sm text-erro-texto">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="email" class="text-sm font-medium">E-mail</label>
                            <input id="email" type="email" name="email" value="{{ old('email', $perfil->email) }}" required autocomplete="email"
                                   class="h-11 rounded-lg border border-borda-forte bg-fundo px-3 text-texto">
                            @error('email')
                            <p class="text-sm text-erro-texto">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end border-t border-borda px-6 py-4">
                        <button type="submit" class="h-11 rounded-lg bg-ambar px-5 font-semibold text-sobre-ambar">Salvar dados</button>
                    </div>
                </form>
            </section>

            {{-- Senha --}}
            <section id="senha" class="scroll-mt-6 rounded-2xl border border-borda bg-superficie">
                <div class="border-b border-borda px-6 py-5">
                    <h2 class="text-lg font-semibold">Alterar senha</h2>
                    <p class="mt-1 text-sm text-suave">Use pelo menos 8 caracteres.</p>
                </div>

                <form method="POST" action="{{ route('conta.senha') }}">
                    @csrf
                    @method('PATCH')

                    <div class="grid gap-5 px-6 py-6 md:grid-cols-2">
                        <div class="flex flex-col gap-2 md:col-span-2 md:max-w-[calc(50%-10px)]">
                            <label for="senha_atual" class="text-sm font-medium">Senha atual</label>
                            <input id="senha_atual" type="password" name="senha_atual" required autocomplete="current-password"
                                   class="h-11 rounded-lg border border-borda-forte bg-fundo px-3 text-texto">
                            @error('senha_atual')
                            <p class="text-sm text-erro-texto">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="senha" class="text-sm font-medium">Nova senha</label>
                            <input id="senha" type="password" name="senha" required autocomplete="new-password"
                                   class="h-11 rounded-lg border border-borda-forte bg-fundo px-3 text-texto">
                            @error('senha')
                            <p class="text-sm text-erro-texto">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="senha_confirmation" class="text-sm font-medium">Confirmar nova senha</label>
                            <input id="senha_confirmation" type="password" name="senha_confirmation" required autocomplete="new-password"
                                   class="h-11 rounded-lg border border-borda-forte bg-fundo px-3 text-texto">
                        </div>
                    </div>

                    <div class="flex justify-end border-t border-borda px-6 py-4">
                        <button type="submit" class="h-11 rounded-lg bg-ambar px-5 font-semibold text-sobre-ambar">Alterar senha</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-layouts::app>
