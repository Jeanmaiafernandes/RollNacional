{{-- Ícones em SVG de traço. Uso: @include('parciais.icone', ['nome' => 'dado', 'tamanho' => 16, 'cor' => '...']) --}}
@php
    $tamanho = $tamanho ?? 18;
    $cor = $cor ?? 'currentColor';
    $espessura = $espessura ?? 2;
@endphp
<svg width="{{ $tamanho }}" height="{{ $tamanho }}" viewBox="0 0 24 24" fill="none" stroke="{{ $cor }}" stroke-width="{{ $espessura }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
@switch($nome)
    @case('d20')
        <path d="M12 2 20 7v10l-8 5-8-5V7z"/><path d="M12 2v20M4 7l8 5 8-5"/>
        @break
    @case('campanhas')
        <rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 10h18"/>
        @break
    @case('pessoa')
        <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>
        @break
    @case('lista')
        <path d="M4 6h16M4 12h16M4 18h10"/>
        @break
    @case('mais')
        <path d="M12 5v14M5 12h14"/>
        @break
    @case('voltar')
        <path d="M15 5l-7 7 7 7"/>
        @break
    @case('seta')
        <path d="M5 12h14M13 6l6 6-6 6"/>
        @break
    @case('copiar')
        <rect x="9" y="9" width="11" height="11" rx="2"/><path d="M5 15V5a1 1 0 0 1 1-1h10"/>
        @break
    @case('dado')
        <rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8" cy="8" r="1.5" fill="{{ $cor }}"/><circle cx="16" cy="16" r="1.5" fill="{{ $cor }}"/><circle cx="12" cy="12" r="1.5" fill="{{ $cor }}"/>
        @break
    @case('cadeado')
        <path d="M17 11V7a5 5 0 0 0-10 0v4"/><rect x="5" y="11" width="14" height="10" rx="2"/>
        @break
    @case('pasta')
        <path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
        @break
    @case('pasta-mais')
        <path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M12 10v6M9 13h6"/>
        @break
    @case('documento')
        <path d="M6 3h8l4 4v14H6z"/><path d="M9 12h6M9 16h6"/>
        @break
    @case('cena')
        <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 3v18"/>
        @break
    @case('imagem')
        <rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="10" r="2"/><path d="M21 16l-5-5-8 8"/>
        @break
    @case('selecionar')
        <path d="M5 3l14 8-7 2-3 7z"/>
        @break
    @case('mover')
        <path d="M12 2v20M2 12h20M12 2l-3 3M12 2l3 3M12 22l-3-3M12 22l3-3M2 12l3-3M2 12l3 3M22 12l-3-3M22 12l-3 3"/>
        @break
    @case('medir')
        <path d="M3 17l14-14 4 4-14 14H3z"/><path d="M7 13l2 2M10 10l2 2M13 7l2 2"/>
        @break
    @case('nevoa')
        <path d="M4 14a4 4 0 0 1 1-7.9A6 6 0 0 1 17 7a4 4 0 0 1 1 7.9H4z"/><path d="M5 19h14"/>
        @break
    @case('token')
        <circle cx="12" cy="12" r="8"/><path d="M12 8v8M8 12h8"/>
        @break
    @case('ok')
        <path d="M5 12l5 5 9-10"/>
        @break
@endswitch
</svg>
