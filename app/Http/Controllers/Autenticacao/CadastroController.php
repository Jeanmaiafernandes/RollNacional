<?php

namespace App\Http\Controllers\Autenticacao;

use App\Http\Controllers\Controller;
use App\Http\Requests\Autenticacao\CadastroRequest;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class CadastroController extends Controller
{
    public function formulario(): View
    {
        return view('autenticacao.registrar');
    }

    public function cadastrar(CadastroRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $usuario = new Usuario();
        $usuario->nome = $dados['nome'];
        $usuario->nome_usuario = $dados['nome_usuario'];
        $usuario->email = $dados['email'];
        $usuario->senha = Hash::make($dados['senha']);
        $usuario->save();

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()->route('inicio')
            ->with('sucesso', 'Cadastro realizado com sucesso!');
    }
}
