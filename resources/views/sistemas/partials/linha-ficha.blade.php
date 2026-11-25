{{-- Linha da ficha técnica; some quando o valor está vazio.
     Uso: @include('sistemas.partials.linha-ficha', ['rotulo' => 'Dado', 'valor' => 'd20']) --}}
@if (filled($valor ?? null))
    <div class="flex items-baseline justify-between gap-3 border-b border-dashed border-linha py-2 last:border-b-0">
        <dt class="font-rotulo text-xs uppercase tracking-[0.12em] text-tinta-3">{{ $rotulo }}</dt>
        <dd class="text-right text-sm font-bold">{{ $valor }}</dd>
    </div>
@endif
