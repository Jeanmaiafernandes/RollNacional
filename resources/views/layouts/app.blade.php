<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'RollNacional') · RollNacional</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@500;700;800&family=Hanken+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/tema.css">
    @stack('estilos')
</head>
<body>
<div class="app">
    @include('parciais.lateral')

    <main class="conteudo">
        @include('parciais.avisos')
        @yield('conteudo')
    </main>
</div>
@stack('scripts')
</body>
</html>
