@props(['personagem', 'dono', 'subtitulo'])

<section aria-label="Identidade" class="rn-cartao flex flex-wrap items-center gap-6 p-6">
    <x-avatar :nome="$personagem->nome" forma="quadrada" tamanho="lg" class="rounded-[20px]! border border-borda-forte" />
    <div class="flex flex-[1_1_340px] flex-col gap-2">
        <div class="flex flex-wrap items-center gap-2.5">
            <h1 class="font-titulo text-[34px] font-extrabold tracking-tight">{{ $personagem->nome }}</h1>
            <x-etiqueta-sistema :cor="$personagem->sistema->cor">{{ $personagem->sistema->nome }}</x-etiqueta-sistema>
        </div>
        <p class="text-[15px] text-texto-2">{{ $subtitulo }}</p>
        <p class="text-sm text-suave">Jogador: {{ $dono->nome }} · Ficha {{ $personagem->publica ? 'pública' : 'privada' }}</p>
    </div>
    {{ $slot }}
</section>
