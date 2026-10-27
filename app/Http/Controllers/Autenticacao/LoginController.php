<?php

namespace App\Http\Controllers\Autenticacao;

use App\Http\Controllers\Controller;
use App\Http\Requests\Autenticacao\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function formulario(): View
    {
        return view('autenticacao.login');
    }

    public function entrar(LoginRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $credenciais = [
            'email' => $dados['email'],
            'password' => $dados['senha'],
        ];

        if (! Auth::attempt($credenciais, $request->boolean('lembrar'))) {
            return back()
                ->withErrors(['email' => 'E-mail ou senha incorretos!'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('inicio'))
            ->with('sucesso', 'Login realizado com sucesso!');
    }
}
