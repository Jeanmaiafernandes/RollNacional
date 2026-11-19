{{-- Mensagens de sessão: ->with('sucesso', '...') ou ->with('erro', '...') no controller --}}
@if (session('sucesso'))
    <div role="status" class="aviso">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8a6516" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg>
        <span>{{ session('sucesso') }}</span>
    </div>
@endif

@if (session('erro'))
    <div role="alert" class="aviso aviso-erro">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#a8191f" stroke-width="2.2" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v6M12 16.5v.5"/></svg>
        <span>{{ session('erro') }}</span>
    </div>
@endif
