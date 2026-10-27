{{-- Layout de visitante (login e cadastro). Metade esquerda: marca, d20 em wireframe e chamada. Metade direita: formulário. Seções: titulo, conteudo. --}}
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Entrar') · RollNacional</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@500;700;800&family=Hanken+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/tema.css">
    <style>
        .visitante { min-height: 100vh; display: grid; grid-template-columns: 1fr 1fr; }
        @media (max-width: 860px) { .visitante { grid-template-columns: 1fr; } }

        .visitante__lado {
            position: relative; overflow: hidden; min-height: 420px;
            padding: 56px 72px; display: flex; flex-direction: column; justify-content: space-between;
            background-color: #1a1430;
            background-image: linear-gradient(#262040 1px, transparent 1px), linear-gradient(90deg, #262040 1px, transparent 1px);
            background-size: 48px 48px;
        }
        .visitante__lado .lateral__marca { padding: 0; position: relative; z-index: 1; }
        .visitante__d20 { position: absolute; left: 50%; top: -3%; width: 46%; max-width: 440px; height: auto; opacity: 0.95; }
        .visitante__chamada { position: relative; z-index: 1; }
        .visitante__chamada h1 { font-size: clamp(56px, 6.5vw, 96px); font-weight: 800; line-height: 0.98; letter-spacing: -2px; }
        .visitante__chamada p { color: var(--texto-medio); font-size: 20px; margin: 24px 0 0; max-width: 460px; line-height: 1.5; }
        @media (max-width: 860px) { .visitante__lado { padding: 32px 24px; min-height: 0; } .visitante__d20 { display: none; } .visitante__chamada h1 { font-size: 44px; } .visitante__chamada p { font-size: 16px; margin-top: 12px; } }

        .visitante__form { background: var(--lateral); display: flex; align-items: center; justify-content: center; padding: 48px 32px; min-height: 100vh; box-sizing: border-box; }
        .visitante__caixa { width: 100%; max-width: 500px; display: flex; flex-direction: column; gap: 24px; }
        .visitante__caixa h2 { font-size: 44px; font-weight: 800; letter-spacing: -1px; }
        .visitante__caixa h2 + p { margin: 8px 0 0; color: var(--texto-fraco); font-size: 16px; }
        .visitante__caixa form { display: flex; flex-direction: column; gap: 20px; }
        .visitante__caixa .campo { font-size: 14px; font-weight: 600; color: #fff; gap: 8px; }
        .visitante__caixa .entrada { height: 60px; font-size: 16px; padding: 0 16px; background: var(--fundo); }
        .visitante__caixa .botao { height: 56px; font-size: 16px; }
        .visitante__caixa .marcar { font-size: 15px; color: var(--texto); gap: 10px; }
        .visitante__caixa .marcar .caixa { width: 20px; height: 20px; border-radius: 4px; }
        .ou { display: flex; align-items: center; gap: 12px; color: var(--texto-fraco); font-size: 13px; }
        .ou::before, .ou::after { content: ""; flex: 1; height: 1px; background: var(--borda); }
    </style>
</head>
<body>
<div class="visitante">
    <aside class="visitante__lado">
        <a href="{{ route('autenticacao.login') }}" class="lateral__marca">
            @include('parciais.icone', ['nome' => 'd20', 'tamanho' => 32, 'cor' => 'var(--primario)'])
            <span>RollNacional</span>
        </a>
        <svg class="visitante__d20" viewBox="0 0 400 440" fill="none" stroke="#5a44b5" stroke-width="6" stroke-linejoin="round" aria-hidden="true">
            <path d="M200 12 386 118v204L200 428 14 322V118z"/>
            <path d="M200 12 86 230l114 72 114-72z"/>
            <path d="M14 118l72 112M386 118l-72 112M14 322l72-92M386 322l-72-92M200 428V302"/>
        </svg>
        <div class="visitante__chamada">
            <h1>A mesa<br>está posta.</h1>
            <p>Mesa virtual para sistemas de RPG nacionais e independentes.</p>
        </div>
    </aside>
    <main class="visitante__form">
        <div class="visitante__caixa">
            @include('parciais.avisos')
            @yield('conteudo')
        </div>
    </main>
</div>
</body>
</html>
