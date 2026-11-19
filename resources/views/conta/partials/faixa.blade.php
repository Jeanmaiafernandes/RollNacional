{{-- Cabeçalho das páginas de conta: foto ou iniciais, título e atalho para o perfil público --}}
@php
    $usuario = auth()->user();
    $iniciais = collect(preg_split('/\s+/', trim($usuario->nome ?? '')))
        ->filter()->take(2)->map(fn ($parte) => mb_strtoupper(mb_substr($parte, 0, 1)))->implode('');
@endphp

<div class="flex flex-wrap items-center gap-6">
    @if ($usuario->caminho_avatar)
        <img src="{{ asset('storage/'.$usuario->caminho_avatar) }}" alt="" class="size-24 rounded-full border-[3px] border-dourado object-cover">
    @else
        <span class="flex size-24 items-center justify-center rounded-full border-[3px] border-dourado bg-papel font-rotulo text-[34px] font-semibold">{{ $iniciais }}</span>
    @endif
    <div class="flex flex-col gap-1.5">
        <h1 class="text-5xl md:text-[56px]">{{ $titulo }}</h1>
        <span class="text-lg text-tinta-2">
            {{ $usuario->nome }} · {{ '@'.$usuario->nome_usuario }}
            @if (Route::has('usuarios.show'))
                · <a href="{{ route('usuarios.show', $usuario->nome_usuario) }}">ver perfil público</a>
            @endif
        </span>
    </div>
</div>
