{{-- Campos do sistema (admin). $sistema null ao criar. Campos: nome, slug, editora, descricao, site_oficial, aviso_licenca, modelo_base, status, capa (file). --}}
<div class="grade grade--2" style="gap: 16px">
    <label for="nome" class="campo">Nome
        <input type="text" id="nome" name="nome" value="{{ old('nome', $sistema?->nome) }}" required maxlength="80" class="entrada entrada--grande">
    </label>
    <label for="slug" class="campo">Slug <span class="apagado">(único, só letras, números e hífen)</span>
        <input type="text" id="slug" name="slug" value="{{ old('slug', $sistema?->slug) }}" required maxlength="60" pattern="[a-z0-9-]+" class="entrada entrada--mono" style="letter-spacing: 0" placeholder="ordem-paranormal">
    </label>
    <label for="editora" class="campo">Editora
        <input type="text" id="editora" name="editora" value="{{ old('editora', $sistema?->editora) }}" maxlength="80" class="entrada">
    </label>
    <label for="modelo_base" class="campo">Modelo base <span class="apagado">(ex.: d20 · atributos 0–5)</span>
        <input type="text" id="modelo_base" name="modelo_base" value="{{ old('modelo_base', $sistema?->modelo_base) }}" maxlength="80" class="entrada">
    </label>
    <label for="site_oficial" class="campo">Site oficial
        <input type="url" id="site_oficial" name="site_oficial" value="{{ old('site_oficial', $sistema?->site_oficial) }}" class="entrada" placeholder="https://">
    </label>
    <label for="status" class="campo">Status
        <select id="status" name="status" class="selecao">
            @foreach (\App\Enums\StatusSistema::cases() as $caso)
                <option value="{{ $caso->value }}" @selected(old('status', $sistema?->status?->value ?? $caso->value) === $caso->value)>{{ $caso->rotulo() }}</option>
            @endforeach
        </select>
    </label>
    <label for="descricao" class="campo grade__2col">Descrição
        <textarea id="descricao" name="descricao" rows="4" class="area">{{ old('descricao', $sistema?->descricao) }}</textarea>
    </label>
    <label for="aviso_licenca" class="campo grade__2col">Aviso de licença <span class="apagado">(aparece em âmbar para os usuários)</span>
        <input type="text" id="aviso_licenca" name="aviso_licenca" value="{{ old('aviso_licenca', $sistema?->aviso_licenca) }}" maxlength="200" class="entrada">
    </label>
    <label for="capa" class="campo grade__2col">Capa <span class="apagado">(opcional, imagem)</span>
        <input type="file" id="capa" name="capa" accept="image/*" class="entrada" style="padding: 8px 12px; height: auto">
    </label>
</div>
