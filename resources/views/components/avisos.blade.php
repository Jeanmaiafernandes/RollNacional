@if (session('sucesso'))
    <x-alerta tipo="sucesso">{{ session('sucesso') }}</x-alerta>
@endif

@if (session('aviso'))
    <x-alerta>{{ session('aviso') }}</x-alerta>
@endif

@if (session('erro'))
    <x-alerta tipo="erro">{{ session('erro') }}</x-alerta>
@endif
