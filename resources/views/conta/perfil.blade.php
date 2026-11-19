@extends('layouts.app')

@php
    $avatarAtual = $usuario->caminho_avatar ? asset('storage/'.$usuario->caminho_avatar) : null;
@endphp

@section('titulo', 'Editar perfil')
@section('trilha')
    @if (Route::has('conta.dados'))<a href="{{ route('conta.dados') }}">Minha conta</a> · @endif Perfil público
@endsection
@section('capitulo', 'Perfil')

@section('faixa')
    <div class="flex flex-wrap items-end justify-between gap-5">
        <div class="flex flex-col items-start gap-2">
            <h1 class="text-5xl md:text-[56px]">Editar perfil</h1>
            <span class="text-lg text-tinta-2">Como os outros jogadores veem você na mesa.</span>
        </div>
        <span class="etiqueta">Sua apresentação de aventureiro</span>
    </div>
@endsection

@section('conteudo')
    <div class="flex flex-wrap items-start gap-10"
         x-data="{
             nome: @js(old('nome', $usuario->nome)),
             usuario: @js(old('nome_usuario', $usuario->nome_usuario)),
             bio: @js(old('bio', $usuario->bio)),
             foto: @js($avatarAtual),
             trocarFoto(evento) {
                 const arquivo = evento.target.files[0];
                 this.foto = arquivo ? URL.createObjectURL(arquivo) : @js($avatarAtual);
             },
         }">

        @include('conta.partials.menu', ['ativo' => 'perfil'])

        {{-- Formulário --}}
        <form method="POST" action="{{ route('conta.perfil.atualizar') }}" enctype="multipart/form-data"
              class="cartao flex min-w-0 flex-[999_1_520px] flex-col gap-6" novalidate>
            @csrf
            @method('PUT')

            <h2 class="barras text-3xl">Perfil público</h2>

            {{-- Foto --}}
            <div class="flex flex-wrap items-center gap-7">
                <div class="relative -rotate-2 border border-linha bg-papel p-2 pb-5 shadow-[0_12px_22px_rgba(60,20,10,0.14)]">
                    <span class="fita" style="width: 60px; margin-left: -30px;" aria-hidden="true"></span>
                    <template x-if="foto">
                        <img :src="foto" alt="" class="block size-[120px] border-[1.5px] border-linha object-cover">
                    </template>
                    <template x-if="! foto">
                        <x-retrato tamanho="120" />
                    </template>
                </div>

                <div class="flex flex-[1_1_260px] flex-col gap-2.5">
                    <span class="rotulo">Foto do perfil</span>
                    <p class="text-base leading-relaxed text-tinta-3">JPG, PNG ou WebP, até 2 MB. A imagem é recortada em quadrado.</p>
                    <div class="flex flex-wrap items-center gap-3.5">
                        <label for="avatar" class="btn-sec btn-pequeno">Enviar imagem</label>
                        <input id="avatar" name="avatar" type="file" accept="image/png,image/jpeg,image/webp" class="sr-only" @change="trocarFoto($event)">
                        @if ($usuario->caminho_avatar)
                            <label class="flex cursor-pointer items-center gap-2 font-rotulo text-sm font-semibold uppercase tracking-[0.12em] text-vermelho">
                                <input type="checkbox" name="remover_avatar" value="1" class="size-4 accent-vermelho" @change="foto = $event.target.checked ? null : @js($avatarAtual)">
                                Remover foto
                            </label>
                        @endif
                    </div>
                    @error('avatar')
                    <p class="erro">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <hr class="border-0 border-t border-dotted border-pontilhado">

            <x-campo nome="nome" rotulo="Nome de exibição" :valor="old('nome', $usuario->nome)" autocomplete="name" x-model="nome" required />

            {{-- Nome de usuário com o começo do endereço fixo --}}
            <div class="flex flex-col gap-2">
                <label for="nome_usuario" class="rotulo">Nome de usuário</label>
                <div class="flex h-[52px] items-stretch border-2 bg-papel {{ $errors->has('nome_usuario') ? 'border-vermelho' : 'border-tinta' }}">
                    <span class="hidden items-center border-r border-linha-2 bg-marfim px-3 text-base whitespace-nowrap text-tinta-3 sm:flex">{{ str_replace(['http://', 'https://'], '', url('/usuarios')) }}/</span>
                    <input id="nome_usuario" name="nome_usuario" type="text" value="{{ old('nome_usuario', $usuario->nome_usuario) }}"
                           autocomplete="username" x-model="usuario" required
                           @error('nome_usuario') aria-invalid="true" aria-describedby="nome_usuario-erro" @else aria-describedby="nome_usuario-dica" @enderror
                           class="min-w-0 flex-1 border-0 bg-transparent px-3 text-lg">
                </div>
                @error('nome_usuario')
                <p id="nome_usuario-erro" class="erro">{{ $message }}</p>
                @else
                    <p id="nome_usuario-dica" class="dica">Letras minúsculas, números e traço. Mudar o nome muda o endereço do perfil.</p>
                    @enderror
            </div>

            <x-campo nome="bio" rotulo="Sobre você" tipo="textarea" :valor="old('bio', $usuario->bio)" rows="4" maxlength="280"
                     dica="Até 280 caracteres. Aparece embaixo do seu nome." x-model="bio" />

            <hr class="border-0 border-t border-dotted border-pontilhado">

            {{-- Sistemas: texto fixo até a tabela de sistemas existir --}}
            <div class="flex flex-col gap-2.5">
                <span class="rotulo">Sistemas que você joga</span>
                <p class="text-base leading-relaxed text-tinta-3">Em breve você vai poder marcar Tormenta20, D&amp;D 5e e os próximos sistemas para eles aparecerem como selos no seu perfil.</p>
            </div>

            <hr class="border-0 border-t border-dotted border-pontilhado">

            {{-- Visibilidade dos personagens --}}
            <label class="flex cursor-pointer items-start justify-between gap-5">
                <span class="flex flex-col gap-1.5">
                    <span class="rotulo">Mostrar personagens no perfil</span>
                    <span class="text-base leading-relaxed text-tinta-3">Outros jogadores veem suas fichas em modo leitura. Desligado, o perfil mostra só nome, foto e apresentação.</span>
                </span>
                <input type="hidden" name="mostrar_personagens" value="0">
                <input type="checkbox" name="mostrar_personagens" value="1" role="switch" class="peer sr-only"
                    @checked(old('mostrar_personagens', $usuario->mostrar_personagens ?? true))>
                <span aria-hidden="true"
                      class="relative h-8 w-[60px] shrink-0 rounded-full border-2 border-tinta bg-linha transition-colors
                             after:absolute after:top-[3px] after:left-[3px] after:size-[22px] after:rounded-full after:bg-white after:transition-transform
                             peer-checked:bg-vermelho peer-checked:after:translate-x-7
                             peer-focus-visible:outline-3 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-dourado-claro"></span>
            </label>

            <div class="flex flex-wrap items-center justify-between gap-3.5 border-t border-dotted border-pontilhado pt-5">
                @if (Route::has('usuarios.show'))
                    <a href="{{ route('usuarios.show', $usuario->nome_usuario) }}" class="link-rotulo text-[15px]">← Cancelar</a>
                @endif
                <button type="submit" class="btn">Salvar perfil</button>
            </div>
        </form>

        {{-- Prévia ao vivo (Alpine) --}}
        <aside aria-label="Prévia do perfil" class="flex flex-[1_1_280px] flex-col gap-3 self-start md:sticky md:top-6 md:max-w-[340px]">
            <span class="sobrelinha text-[13px]">Prévia</span>
            <div class="border-2 border-tinta bg-papel" style="box-shadow: inset 0 6px 0 var(--color-vermelho)">
                <div class="flex flex-col items-center gap-2.5 bg-marfim px-5 pt-8 pb-5 text-center">
                    <div class="relative -rotate-2 border border-linha bg-papel p-1.5 pb-4 shadow-[0_8px_16px_rgba(60,20,10,0.12)]">
                        <span class="fita" style="width: 44px; margin-left: -22px;" aria-hidden="true"></span>
                        <template x-if="foto">
                            <img :src="foto" alt="" class="block size-[84px] border-[1.5px] border-linha object-cover">
                        </template>
                        <template x-if="! foto">
                            <x-retrato tamanho="84" />
                        </template>
                    </div>
                    <span class="mt-1.5 font-rotulo text-sm font-semibold tracking-[0.16em] text-dourado-texto" x-text="'@' + usuario"></span>
                    <span class="text-3xl font-bold uppercase leading-none tracking-[0.05em]" x-text="nome"></span>
                </div>
                <div class="flex flex-col gap-3.5 px-5 pt-4 pb-5">
                    <p class="text-base italic leading-relaxed text-tinta-2" x-show="bio" x-text="bio"></p>
                    <p class="text-base italic text-tinta-3" x-show="! bio">Sem apresentação.</p>
                </div>
            </div>
            @if (Route::has('usuarios.show'))
                <a href="{{ route('usuarios.show', $usuario->nome_usuario) }}" class="link-rotulo">Ver perfil completo →</a>
            @endif
        </aside>
    </div>
@endsection
