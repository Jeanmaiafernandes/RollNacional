{{-- Logotipo: losango vermelho com dourado + nome --}}
<a href="{{ $link ?? route('pagina-inicial') }}" class="flex items-center gap-2.5 text-tinta no-underline hover:text-tinta">
    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linejoin="round" aria-hidden="true">
        <path d="M12 2l9 10-9 10-9-10z" stroke="#a8191f"/>
        <path d="M12 7l4.5 5-4.5 5-4.5-5z" stroke="#c8962e" fill="#c8962e" fill-opacity="0.25"/>
    </svg>
    <span class="font-rotulo text-[17px] font-bold uppercase tracking-[0.2em]">Roll<span class="text-vermelho">Nacional</span></span>
</a>
