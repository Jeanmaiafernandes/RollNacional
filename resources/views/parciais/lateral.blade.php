{{-- Barra lateral da área logada. Usa auth()->user() (model Usuario: nome, email, administrador). --}}
@php
    $usuario = auth()->user();
    $iniciais = \Illuminate\Support\Str::of($usuario->nome)->explode(' ')->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode('');
@endphp
<nav class="lateral" aria-label="Navegação principal">
    <a href="{{ route('inicio') }}" class="lateral__marca">
        @include('parciais.icone', ['nome' => 'd20', 'tamanho' => 28, 'cor' => 'var(--primario)'])
        <span>RollNacional</span>
    </a>

    <a href="{{ route('inicio') }}" class="lateral__link {{ request()->routeIs('inicio', 'campanhas.*') ? 'ativo' : '' }}">
        @include('parciais.icone', ['nome' => 'campanhas'])
        Campanhas
    </a>
    <a href="{{ route('personagens.listar') }}" class="lateral__link {{ request()->routeIs('personagens.*') ? 'ativo' : '' }}">
        @include('parciais.icone', ['nome' => 'pessoa'])
        Personagens
    </a>
    @can('administrar')
        <a href="{{ Route::has('admin.sistemas.listar') ? route('admin.sistemas.listar') : route('sistemas.listar') }}"
           class="lateral__link {{ request()->routeIs('admin.*', 'sistemas.*') ? 'ativo' : '' }}">
            @include('parciais.icone', ['nome' => 'lista'])
            Sistemas <span class="selo selo--admin" style="margin-left: auto">ADMIN</span>
        </a>
    @endcan

    <div class="lateral__espaco"></div>

    <div class="lateral__usuario">
        <div class="lateral__pessoa">
            <span class="avatar" aria-hidden="true">{{ mb_strtoupper($iniciais) }}</span>
            <div style="min-width: 0">
                <strong>{{ $usuario->nome }}</strong>
                <span>{{ $usuario->email }}</span>
            </div>
        </div>
        <a href="{{ route('perfil') }}" class="lateral__acao">Perfil</a>
        <form method="POST" action="{{ route('autenticacao.sair') }}">
            @csrf
            <button type="submit" class="lateral__acao">Sair</button>
        </form>
    </div>
</nav>
