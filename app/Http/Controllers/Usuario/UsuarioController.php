<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function show(Usuario $usuario): View
    {
        return view('usuarios.show', ['usuario' => $usuario]);
    }
}
