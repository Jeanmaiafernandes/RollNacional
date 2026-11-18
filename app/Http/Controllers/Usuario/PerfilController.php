<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\AtualizarPerfilRequest;
use App\Http\Requests\Usuario\AtualizarSenhaRequest;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PerfilController extends Controller
{
    public function perfil(Request $request): View
    {
        return view('usuarios.perfil', ['perfil' => $request->user()]);
    }

    public function atualizarPerfil(AtualizarPerfilRequest $request): RedirectResponse
    {
        $request->user()->update($request->validated());

        return redirect()->back()->with('sucesso', 'Dados atualizados.');
    }

    public function atualizarSenha(AtualizarSenhaRequest $request): RedirectResponse
    {
        $request->session()->put(
            'password_hash_web',
            Auth::guard('web')->hashPasswordForCookie($request->user()->getAuthPassword())
        );

        $request->session()->put('password_hash_web', $request->user()->getAuthPassword());

        return redirect()->back()->with('sucesso', 'Dados atualizados.');
    }
}
