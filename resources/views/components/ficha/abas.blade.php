@props(['abas'])

<div x-data="{ aba: @js(array_key_first($abas)) }" {{ $attributes->class('flex flex-col gap-5') }}>
    <div role="tablist" aria-label="Seções da ficha" class="flex flex-wrap gap-1 border-b border-borda">
        @foreach ($abas as $chave => $texto)
            <button type="button" role="tab" id="aba-{{ $chave }}"
                    x-on:click="aba = @js($chave)"
                    x-bind:aria-selected="(aba === @js($chave)).toString()"
                    aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                    x-bind:class="aba === @js($chave)
                        ? 'border-ambar font-semibold text-ambar-claro'
                        : 'border-transparent font-medium text-texto-2 hover:text-texto'"
                    {{-- Cor e borda só pelo x-bind:class, para não competir com classes estáticas. --}}
                    class="h-[46px] cursor-pointer border-b-2 bg-transparent px-4 text-[15px]">{{ $texto }}</button>
        @endforeach
    </div>

    {{ $slot }}
</div>
