{{-- Coluna de runas decorativas na margem (só enfeite) --}}
@php
    $glifos = [
        'M12 3v18M6 8l6-5 6 5', 'M5 5h14L5 19h14', 'M12 3l7 9-7 9-7-9zM12 8v8', 'M6 4v16M18 4v16M6 12h12',
        'M4 12h16M12 4l4 8-4 8-4-8z', 'M7 4l10 16M17 4L7 20M12 4v4', 'M12 4a8 8 0 1 0 0.01 0M12 8v8M8 12h8',
        'M5 19L12 5l7 14M8 13h8', 'M5 6h14M8 6v12M16 6v12M5 18h14', 'M12 3v6M12 15v6M3 12h6M15 12h6M9 9l6 6',
    ];
@endphp
<div aria-hidden="true" class="pointer-events-none absolute top-10 bottom-10 hidden flex-col gap-3.5 overflow-hidden opacity-50 md:flex {{ $lado ?? 'left-5' }}">
    @for ($i = 0; $i < 26; $i++)
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $cor ?? '#c8962e' }}" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><path d="{{ $glifos[($i * 3) % count($glifos)] }}"/></svg>
    @endfor
</div>
