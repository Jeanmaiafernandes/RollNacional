{{-- Campos compartilhados por criar e editar. $campanha pode ser null; $sistemas = publicados. --}}
<label for="nome" class="campo">Nome da campanha
    <input type="text" id="nome" name="nome" value="{{ old('nome', $campanha?->nome) }}" required maxlength="80" class="entrada entrada--grande" placeholder="A Casa de Vidro">
</label>

@if ($campanha)
    <div class="campo">Sistema
        <div class="entrada" style="display: flex; align-items: center; color: var(--texto-fraco)">{{ $campanha->sistema->nome }} <span class="apagado pequeno" style="margin-left: 8px">· fixo desde a criação</span></div>
    </div>
@else
    <label for="sistema_jogo_id" class="campo">Sistema
        <select id="sistema_jogo_id" name="sistema_jogo_id" required class="selecao">
            <option value="">Escolha um sistema publicado</option>
            @foreach ($sistemas as $sistema)
                <option value="{{ $sistema->id }}" @selected(old('sistema_jogo_id') == $sistema->id)>{{ $sistema->nome }}@if ($sistema->editora) — {{ $sistema->editora }}@endif</option>
            @endforeach
        </select>
        <span class="apagado">Define a estrutura das fichas da mesa. Não dá para trocar depois.</span>
    </label>
@endif

<label for="descricao" class="campo">Descrição <span class="apagado">(opcional)</span>
    <textarea id="descricao" name="descricao" rows="4" maxlength="2000" class="area" placeholder="Sinopse, dia das sessões, combinados da mesa…">{{ old('descricao', $campanha?->descricao) }}</textarea>
</label>
