{{--
    Form "Novo item" da biblioteca, dentro da mesa. POST biblioteca.salvar.
    Campos: nome, tipo (pasta|anotacao), pasta_id, visibilidade (oculto|todos — "específico" se ajusta depois na tela do item), conteudo[texto].
    $pastas: pastas da campanha (opcional). Jogador com pode_criar_itens cria só itens próprios; o controller decide.
--}}
<form method="POST" action="{{ route('biblioteca.salvar', $campanha) }}" style="padding: 12px 14px; border-bottom: 1px solid var(--borda); display: flex; flex-direction: column; gap: 10px; background: var(--painel)">
    @csrf
    <input type="hidden" name="_form" value="novo-item">
    <div class="alternador" style="width: max-content" role="group" aria-label="Tipo">
        <label style="display: contents"><input type="radio" name="tipo" value="anotacao" @checked(old('tipo', 'anotacao') === 'anotacao') hidden><span class="{{ old('tipo', 'anotacao') === 'anotacao' ? 'ativo' : '' }}" style="height: 30px; padding: 0 12px; border-radius: 6px; display: inline-flex; align-items: center; cursor: pointer">Anotação</span></label>
        <label style="display: contents"><input type="radio" name="tipo" value="pasta" @checked(old('tipo') === 'pasta') hidden><span class="{{ old('tipo') === 'pasta' ? 'ativo' : '' }}" style="height: 30px; padding: 0 12px; border-radius: 6px; display: inline-flex; align-items: center; cursor: pointer">Pasta</span></label>
    </div>
    <input type="text" name="nome" value="{{ old('nome') }}" required maxlength="80" class="entrada entrada--compacta" placeholder="Nome" aria-label="Nome">
    @if ($pastas->isNotEmpty())
        <select name="pasta_id" class="selecao selecao--compacta" aria-label="Dentro de">
            <option value="">Raiz da biblioteca</option>
            @foreach ($pastas as $pasta)
                <option value="{{ $pasta->id }}" @selected(old('pasta_id') == $pasta->id)>{{ str_repeat('— ', $pasta->nivel ?? 0) }}{{ $pasta->nome }}</option>
            @endforeach
        </select>
    @endif
    @if ($souMestre)
        <select name="visibilidade" class="selecao selecao--compacta" aria-label="Quem vê">
            <option value="oculto" @selected(old('visibilidade', 'oculto') === 'oculto')>Só mestre e co-mestres</option>
            <option value="todos" @selected(old('visibilidade') === 'todos')>Todos os participantes</option>
        </select>
    @endif
    <div style="display: flex; gap: 6px">
        <button type="submit" class="botao botao--primario botao--pequeno" style="flex: 1">Criar</button>
        <button type="button" class="botao botao--contorno botao--pequeno" onclick="document.getElementById('novo-item').open = false">Cancelar</button>
    </div>
</form>
<script>
    document.querySelectorAll('#novo-item input[name="tipo"]').forEach(r => r.addEventListener('change', () => {
        document.querySelectorAll('#novo-item input[name="tipo"]').forEach(o => o.nextElementSibling.classList.toggle('ativo', o.checked));
    }));
</script>
