<x-layouts::app titulo="Início" menu="painel">
    <section class="flex flex-wrap items-end justify-between gap-5">
        <div class="flex flex-col gap-2">
            <p class="text-base text-suave">Continue de onde parou ou comece um personagem novo.</p>
        </div>

    </section>

    <div class="flex flex-wrap items-start gap-7">
        <section aria-labelledby="recentes" class="flex min-w-0 flex-[999_1_560px] flex-col gap-4">

            <div class="mt-2 flex flex-wrap items-center gap-4 rounded-[14px] border border-dashed border-borda-forte bg-recuo p-5">
                <x-icone nome="casa" class="size-7 text-suave" stroke-width="1.6" />
                <div class="flex flex-[1_1_300px] flex-col gap-1">
                    <span class="text-[15px] font-semibold">Campanhas e mesa virtual chegam na próxima etapa</span>
                    <span class="text-sm text-suave">Suas fichas já ficam prontas para entrar em uma mesa quando ela abrir.</span>
                </div>
            </div>
        </section>

    </div>
</x-layouts::app>
