@props(['titulo' => null, 'menu' => 'nenhum'])

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @include('layouts.partials.head', ['titulo' => $titulo])
</head>
<body class="min-h-screen">
    <a href="#conteudo" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-superficie focus:px-4 focus:py-2">Pular para o conteúdo</a>

    @include('layouts.partials.cabecalho')

    <main id="conteudo" {{ $attributes->class('mx-auto box-border flex max-w-7xl flex-col gap-7 px-6 pb-20 pt-9') }}>
        <x-avisos />

        {{ $slot }}
    </main>
</body>
</html>
