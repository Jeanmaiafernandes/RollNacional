{{-- Cabeçalho da página inicial pública --}}
<header class="border-t-[5px] border-b border-t-vermelho border-b-linha bg-papel">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center gap-x-9 gap-y-3 px-6 py-4 md:px-8">
        @include('layouts.partials.marca')

        <nav aria-label="Seções" class="hidden flex-1 flex-wrap gap-6 md:flex">
            <a href="#sistemas" class="font-rotulo text-[15px] font-medium tracking-[0.06em] text-tinta-2 no-underline hover:text-tinta">Sistemas</a>
            <a href="#como-funciona" class="font-rotulo text-[15px] font-medium tracking-[0.06em] text-tinta-2 no-underline hover:text-tinta">Como funciona</a>
            <a href="#compendio" class="font-rotulo text-[15px] font-medium tracking-[0.06em] text-tinta-2 no-underline hover:text-tinta">Compêndio</a>
        </nav>

        <div class="ml-auto flex gap-2.5">
            @auth
                <a href="{{ route('inicio') }}" class="btn btn-pequeno">Ir para a mesa</a>
            @else
                <a href="{{ route('entrar') }}" class="btn-sec btn-pequeno">Entrar</a>
                <a href="{{ route('registrar') }}" class="btn btn-pequeno">Criar conta</a>
            @endauth
        </div>
    </div>
</header>
