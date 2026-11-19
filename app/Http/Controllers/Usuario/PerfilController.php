<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\AtualizarEmailRequest;
use App\Http\Requests\Usuario\AtualizarSenhaRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Dados da conta (e-mail) e troca de senha do usuário logado.
 */
class PerfilController extends Controller
{
    public function dados(Request $request): View
    {
        return view('conta.dados', ['usuario' => $request->user()]);
    }

    public function atualizarEmail(AtualizarEmailRequest $request): RedirectResponse
    {
        $request->user()->forceFill([
            'email' => $request->validated('email'),
        ])->save();

        return redirect()->route('conta.dados')->with('sucesso', 'Seu e-mail foi atualizado.');
    }

    public function senha(): View
    {
        return view('conta.senha');
    }

    public function atualizarSenha(AtualizarSenhaRequest $request): RedirectResponse
    {
        $usuario = $request->user();

        $usuario->forceFill([
            'senha' => Hash::make($request->validated('senha')),
        ])->save();

        // Mantém esta sessão válida; as sessões de outros aparelhos caem pelo middleware auth.session.
        $request->session()->put(
            'password_hash_'.Auth::getDefaultDriver(),
            Auth::guard()->hashPasswordForCookie($usuario->getAuthPassword())
        );

        return redirect()->route('conta.senha')->with('sucesso', 'Sua senha foi trocada.');
    }
}
