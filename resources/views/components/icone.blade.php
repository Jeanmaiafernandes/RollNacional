@props(['nome', 'rotulo' => null])

@php
    $caminhos = [
        'd20' => '<polygon points="12,2 21,7 21,17 12,22 3,17 3,7"/><polygon points="12,6.5 17,15.5 7,15.5"/><path d="M12 2v4.5M21 7l-4 8.5M3 7l4 8.5M12 22l-5-6.5M12 22l5-6.5M3 17l4-1.5M21 17l-4-1.5"/>',
        'mais' => '<path d="M12 5v14M5 12h14"/>',
        'busca' => '<circle cx="11" cy="11" r="6.5"/><path d="M20 20l-4.2-4.2"/>',
        'sino' => '<path d="M6 9a6 6 0 0 1 12 0c0 6 2.5 7.5 2.5 7.5h-17S6 15 6 9z"/><path d="M10 20a2.2 2.2 0 0 0 4 0"/>',
        'chevron-baixo' => '<path d="M6 9l6 6 6-6"/>',
        'chevron-direita' => '<path d="M9 6l6 6-6 6"/>',
        'chevron-esquerda' => '<path d="M15 6l-6 6 6 6"/>',
        'seta-direita' => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'usuarios' => '<circle cx="12" cy="8.5" r="3.5"/><path d="M5 19.5c1.2-3.3 3.8-5 7-5s5.8 1.7 7 5"/>',
        'ficha' => '<rect x="5" y="3.5" width="14" height="17" rx="2"/><path d="M9 8h6M9 12h6M9 16h3"/>',
        'engrenagem' => '<circle cx="12" cy="12" r="3"/><path d="M12 2.8v2.4M12 18.8v2.4M4.6 4.6l1.7 1.7M17.7 17.7l1.7 1.7M2.8 12h2.4M18.8 12h2.4M4.6 19.4l1.7-1.7M17.7 6.3l1.7-1.7"/>',
        'sair' => '<path d="M14 4h4a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-4"/><path d="M10 16l-4-4 4-4M6 12h10"/>',
        'check' => '<path d="M5 12.5l4.5 4.5L19 7"/>',
        'circulo' => '<circle cx="12" cy="12" r="7"/>',
        'alerta' => '<circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16.5v.5"/>',
        'info' => '<circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 7.5v.5"/>',
        'cadeado' => '<rect x="4.5" y="10.5" width="15" height="10" rx="2"/><path d="M8 10.5V7.5a4 4 0 0 1 8 0v3"/><path d="M12 14.5v2"/>',
        'envelope' => '<rect x="3" y="5.5" width="18" height="13" rx="2"/><path d="M3.5 7l8.5 6.5L20.5 7"/>',
        'link' => '<path d="M10 14a4 4 0 0 0 5.7 0l3-3a4 4 0 0 0-5.7-5.7l-1 1"/><path d="M14 10a4 4 0 0 0-5.7 0l-3 3a4 4 0 0 0 5.7 5.7l1-1"/>',
        'lapis' => '<path d="M4 20h4L19 9l-4-4L4 16v4z"/>',
        'download' => '<path d="M12 4v11M7.5 10.5L12 15l4.5-4.5"/><path d="M5 19.5h14"/>',
        'upload' => '<path d="M12 15V4M7.5 8.5L12 4l4.5 4.5"/><path d="M5 19.5h14"/>',
        'estrela' => '<path d="M12 3.5l2.6 5.3 5.9.9-4.3 4.1 1 5.8-5.2-2.7-5.2 2.7 1-5.8-4.3-4.1 5.9-.9z"/>',
        'monitor' => '<rect x="3" y="4.5" width="18" height="12" rx="2"/><path d="M8 20h8M12 16.5V20"/>',
        'casa' => '<path d="M3 10.5l9-6 9 6"/><path d="M5 9.5V19h14V9.5"/><path d="M9.5 19v-5h5v5"/>',
        'reticencias' => '<circle cx="5.5" cy="12" r="1.2"/><circle cx="12" cy="12" r="1.2"/><circle cx="18.5" cy="12" r="1.2"/>',
        'menu' => '<path d="M4 7h16M4 12h16M4 17h16"/>',
        'fechar' => '<path d="M6 6l12 12M18 6L6 18"/>',
    ];
@endphp

{{-- Sem class informada, o ícone usa size-5; com class, o tamanho é o que vier nela. --}}
<svg class="shrink-0 {{ $attributes->get('class') ?: 'size-5' }}" {{ $attributes->except('class')->merge([
        'viewBox' => '0 0 24 24',
        'fill' => 'none',
        'stroke' => 'currentColor',
        'stroke-width' => '2',
        'stroke-linecap' => 'round',
        'stroke-linejoin' => 'round',
    ]) }} @if ($rotulo) role="img" aria-label="{{ $rotulo }}" @else aria-hidden="true" @endif>{!! $caminhos[$nome] ?? '' !!}</svg>
