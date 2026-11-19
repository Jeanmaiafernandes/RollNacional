{{-- Layout da página inicial pública (visitantes) --}}
    <!DOCTYPE html>
<html lang="pt-BR">
<head>
    @include('layouts.partials.head')
</head>
<body class="flex min-h-screen flex-col overflow-x-hidden">
@include('layouts.partials.cabecalho-publico')

<main id="conteudo" class="flex-1">
    @yield('conteudo')
</main>

@include('layouts.partials.rodape')
</body>
</html>
