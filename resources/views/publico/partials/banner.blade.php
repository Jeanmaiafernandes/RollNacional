{{-- Banner animado da página inicial: janela hexagonal (face de d20) com o castelo,
     selo girando no centro e dados, ficha e pena flutuando. Animações em resources/css/app.css (.rn-*). --}}
<svg class="rn-banner block h-auto w-full overflow-visible" viewBox="612 -24 620 610" role="img" aria-labelledby="rn-titulo rn-desc">
    <title id="rn-titulo">Emblema da RollNacional</title>
    <desc id="rn-desc">Janela hexagonal com o emblema da RollNacional no centro, cercada de dados, uma ficha e uma pena flutuando.</desc>
    <defs>
        <clipPath id="rn-hex">
            <polygon points="1157.0,292.0 1031.0,510.2 779.0,510.2 653.0,292.0 779.0,73.8 1031.0,73.8"/>
        </clipPath>
    </defs>
    <g class="rn-janela">
        <g clip-path="url(#rn-hex)">
            <rect x="640" y="30" width="530" height="520" fill="#f7f3ec"/>
            <image href="{{ asset('img/site/castelo.webp') }}" x="645" y="36" width="520" height="512" preserveAspectRatio="xMidYMid slice"/>
        </g>
        <line class="rn-fenda" x1="905" y1="292" x2="1157.0" y2="292.0" stroke="#ffffff" stroke-width="16" stroke-linecap="round"/>
        <line class="rn-fenda" x1="905" y1="292" x2="1031.0" y2="510.2" stroke="#ffffff" stroke-width="16" stroke-linecap="round"/>
        <line class="rn-fenda" x1="905" y1="292" x2="779.0" y2="510.2" stroke="#ffffff" stroke-width="16" stroke-linecap="round"/>
        <line class="rn-fenda" x1="905" y1="292" x2="653.0" y2="292.0" stroke="#ffffff" stroke-width="16" stroke-linecap="round"/>
        <line class="rn-fenda" x1="905" y1="292" x2="779.0" y2="73.8" stroke="#ffffff" stroke-width="16" stroke-linecap="round"/>
        <line class="rn-fenda" x1="905" y1="292" x2="1031.0" y2="73.8" stroke="#ffffff" stroke-width="16" stroke-linecap="round"/>
        <polygon points="1157.0,292.0 1031.0,510.2 779.0,510.2 653.0,292.0 779.0,73.8 1031.0,73.8" fill="none" stroke="#1c1515" stroke-width="3" stroke-linejoin="round"/>
        <circle cx="905" cy="292" r="84" fill="#ffffff"/>
        <circle cx="905" cy="292" r="74" fill="#a8191f" stroke="#1c1515" stroke-width="3"/>
        <circle cx="905" cy="292" r="44" fill="none" stroke="#e3b75a" stroke-width="1.5" stroke-dasharray="3 5"/>
        <path id="rn-circulo" d="M905,292 m-58,0 a58,58 0 1,1 116,0 a58,58 0 1,1 -116,0" fill="none"/>
        <g class="rn-anel">
            <text font-family="Oswald, sans-serif" font-size="13" font-weight="600" letter-spacing="2.5" fill="#ffffff">
                <textPath href="#rn-circulo" textLength="362">ROLL NACIONAL ✦ MESA VIRTUAL ✦ RPG NACIONAL ✦</textPath>
            </text>
        </g>
        <g transform="translate(905 292)">
            <polygon points="0,-26 22.5,-13 22.5,13 0,26 -22.5,13 -22.5,-13" fill="#e3b75a" stroke="#1c1515" stroke-width="2.5" stroke-linejoin="round"/>
            <polygon points="0,-14 12,7 -12,7" fill="#f0cb6e" stroke="#1c1515" stroke-width="2" stroke-linejoin="round"/>
            <path d="M0,-14 L0,-26 M12,7 L22.5,13 M-12,7 L-22.5,13" stroke="#1c1515" stroke-width="2"/>
        </g>
    </g>
    <path class="rn-brilho" style="animation-delay: 0.3s;" d="M640,111 l2.52,6.48 l6.48,2.52 l-6.48,2.52 l-2.52,6.48 l-2.52,-6.48 l-6.48,-2.52 l6.48,-2.52 Z" fill="#c8962e"/>
    <path class="rn-brilho" style="animation-delay: 1.4s;" d="M1190,143 l1.96,5.04 l5.04,1.96 l-5.04,1.96 l-1.96,5.04 l-1.96,-5.04 l-5.04,-1.96 l5.04,-1.96 Z" fill="#a8191f"/>
    <path class="rn-brilho" style="animation-delay: 2.2s;" d="M1010,552 l2.24,5.76 l5.76,2.24 l-5.76,2.24 l-2.24,5.76 l-2.24,-5.76 l-5.76,-2.24 l5.76,-2.24 Z" fill="#c8962e"/>
    <path class="rn-brilho" style="animation-delay: 1.1s;" d="M630,374 l1.68,4.32 l4.32,1.68 l-4.32,1.68 l-1.68,4.32 l-1.68,-4.32 l-4.32,-1.68 l4.32,-1.68 Z" fill="#a8191f"/>
    <g transform="translate(712 108) rotate(-14)">
        <g class="rn-f1" style="animation-duration: 13s; animation-delay: -4s;">
            <rect x="-46" y="-60" width="92" height="120" rx="3" fill="#fffdf8" stroke="#1c1515" stroke-width="3"/>
            <rect x="-46" y="-60" width="92" height="22" rx="3" fill="#a8191f" stroke="#1c1515" stroke-width="3"/>
            <text x="0" y="-44" text-anchor="middle" font-family="Oswald, sans-serif" font-size="11" font-weight="600" letter-spacing="2" fill="#ffffff">FICHA</text>
            <rect x="-34" y="-28" width="20" height="20" fill="none" stroke="#1c1515" stroke-width="2"/>
            <rect x="-6" y="-28" width="20" height="20" fill="none" stroke="#1c1515" stroke-width="2"/>
            <rect x="22" y="-28" width="12" height="20" fill="#e3b75a" stroke="#1c1515" stroke-width="2"/>
            <path d="M-34,6 H34 M-34,18 H20 M-34,30 H34 M-34,42 H10" stroke="#c9b98f" stroke-width="3" stroke-linecap="round"/>
        </g>
    </g>
    <g transform="translate(686 478)">
        <g class="rn-f2" style="animation-duration: 12s;">
            <polygon points="0,-38 33,-19 0,0 -33,-19" fill="#f0cb6e" stroke="#1c1515" stroke-width="3" stroke-linejoin="round"/>
            <polygon points="-33,-19 0,0 0,38 -33,19" fill="#c8962e" stroke="#1c1515" stroke-width="3" stroke-linejoin="round"/>
            <polygon points="0,0 33,-19 33,19 0,38" fill="#a87a1c" stroke="#1c1515" stroke-width="3" stroke-linejoin="round"/>
            <ellipse cx="0" cy="-19" rx="5" ry="3" fill="#1c1515"/>
            <ellipse cx="-24" cy="-2" rx="3" ry="4" fill="#fffdf8"/>
            <ellipse cx="-10" cy="22" rx="3" ry="4" fill="#fffdf8"/>
            <ellipse cx="10" cy="-4" rx="3" ry="4" fill="#fffdf8"/>
            <ellipse cx="17" cy="9" rx="3" ry="4" fill="#fffdf8"/>
            <ellipse cx="24" cy="22" rx="3" ry="4" fill="#fffdf8"/>
        </g>
    </g>
    <g transform="translate(1118 70)">
        <g class="rn-f1" style="animation-duration: 10s;">
            <polygon points="0,-58 50,-29 50,29 0,58 -50,29 -50,-29" fill="#a8191f" stroke="#1c1515" stroke-width="3.5" stroke-linejoin="round"/>
            <polygon points="0,-58 50,-29 0,-31" fill="#c4323a"/>
            <polygon points="-50,-29 0,-58 0,-31" fill="#d0464d"/>
            <polygon points="0,-31 27,16 -27,16" fill="#c4323a" stroke="#1c1515" stroke-width="2.5" stroke-linejoin="round"/>
            <path d="M0,-31 L0,-58 M0,-31 L50,-29 M0,-31 L-50,-29 M27,16 L50,-29 M27,16 L50,29 M27,16 L0,58 M-27,16 L-50,-29 M-27,16 L-50,29 M-27,16 L0,58" stroke="#1c1515" stroke-width="2.5" stroke-linecap="round"/>
            <text x="0" y="10" text-anchor="middle" font-family="Oswald, sans-serif" font-size="21" font-weight="700" fill="#ffffff">20</text>
        </g>
    </g>
    <g transform="translate(1140 452) rotate(-25)">
        <g class="rn-f2" style="animation-duration: 9s; animation-delay: -2s;">
            <path d="M-6,52 C-2,10 10,-30 38,-62 C40,-20 26,22 -6,52 Z" fill="#f6d9d6" stroke="#1c1515" stroke-width="3" stroke-linejoin="round"/>
            <path d="M-12,66 L-6,52 C6,16 18,-18 34,-50" fill="none" stroke="#1c1515" stroke-width="2.5" stroke-linecap="round"/>
            <path d="M12,8 L26,-2 M6,24 L18,18 M18,-12 L32,-24" stroke="#c8962e" stroke-width="2.5" stroke-linecap="round"/>
        </g>
    </g>
    <g transform="translate(1188 250)">
        <g class="rn-f1" style="animation-duration: 8s; animation-delay: -3s;">
            <polygon points="0,-30 28,20 -28,20" fill="#e3b75a" stroke="#1c1515" stroke-width="3" stroke-linejoin="round"/>
            <polygon points="0,-30 28,20 4,8" fill="#c8962e" stroke="#1c1515" stroke-width="2.5" stroke-linejoin="round"/>
            <text x="-6" y="14" text-anchor="middle" font-family="Oswald, sans-serif" font-size="13" font-weight="700" fill="#1c1515">4</text>
        </g>
    </g>
</svg>
