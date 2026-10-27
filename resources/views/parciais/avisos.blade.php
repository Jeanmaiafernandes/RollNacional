{{-- Flash de sucesso (chave "sucesso") e erros de validação. --}}
@if (session('sucesso'))
    <div class="aviso aviso--sucesso" role="status">{{ session('sucesso') }}</div>
@endif

@if ($errors->any())
    <div class="aviso aviso--erro" role="alert">
        <strong>Confira os campos:</strong>
        <ul>
            @foreach ($errors->all() as $erro)
                <li>{{ $erro }}</li>
            @endforeach
        </ul>
    </div>
@endif
