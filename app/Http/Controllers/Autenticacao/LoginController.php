<?php

namespace App\Http\Controllers\Autenticacao;

use App\Http\Controllers\Controller;
use App\Http\Requests\Autenticacao\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function formulario(): View
    {
        return view('autenticacao.entrar');
    }

    public function entrar(LoginRequest $request): RedirectResponse
    {
        $credenciais = [
            'email' => $request->validated('email'),
            'password' => $request->validated('senha'),
        ];

        if (! Auth::attempt($credenciais, $request->boolean('lembrar'))) {
            throw ValidationException::withMessages([
                'email' => 'E-mail ou senha incorretos.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('inicio'));
    }
}
