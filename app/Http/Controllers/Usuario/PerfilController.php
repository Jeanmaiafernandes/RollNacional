<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\AtualizarPerfilRequest;
use App\Http\Requests\Usuario\AtualizarSenhaRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PerfilController extends Controller
{
    public function exibir(Request $request): View
    {
        return view('usuarios.perfil', [
            'usuarios' => $request->user(),
        ]);
    }

    public function atualizar(AtualizarPerfilRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $usuario = $request->user();
        $usuario->nome = $dados['nome'];
        $usuario->email = $dados['email'];
        $usuario->save();

        return redirect()->route('perfil')
            ->with('sucesso', 'Dados atualizados com sucesso!');
    }

    public function atualizarSenha(AtualizarSenhaRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $usuario = $request->user();
        $usuario->senha = $dados['senha'];
        $usuario->save();

        return redirect()->route('perfil')
            ->with('sucesso', 'Senha atualizada com sucesso!');
    }
}
