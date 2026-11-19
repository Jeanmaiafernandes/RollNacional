<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\AtualizarPerfilPublicoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EditarPerfilController extends Controller
{
    public function editar(Request $request): View
    {
        return view('conta.perfil', ['usuario' => $request->user()]);
    }

    public function atualizar(AtualizarPerfilPublicoRequest $request): RedirectResponse
    {
        $usuario = $request->user();

        $dados = $request->safe()->only(['nome', 'nome_usuario', 'bio']);
        $dados['mostrar_personagens'] = $request->boolean('mostrar_personagens');

        if ($usuario->caminho_avatar && ($request->boolean('remover_avatar') || $request->hasFile('avatar'))) {
            Storage::disk('public')->delete($usuario->caminho_avatar);
            $dados['caminho_avatar'] = null;
        }

        if ($request->hasFile('avatar')) {
            $dados['caminho_avatar'] = $request->file('avatar')->store('avatares', 'public');
        }

        $usuario->forceFill($dados)->save();

        return redirect()->route('conta.perfil')->with('sucesso', 'Seu perfil foi atualizado.');
    }
}
