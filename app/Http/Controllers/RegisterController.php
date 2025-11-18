<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
    public function showRegistrationForm()
    {
        return view('login'); 
    }

     public function register(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'username' => 'required|string|max:255|unique:Usuarios,username',
            'email' => 'required|string|email|max:255|unique:Usuarios,email',
            'contraseña' => 'required|string|min:6|confirmed',
        ]);

        // Crear un nuevo usuario
        $usuario = new \App\Models\Usuarios();
        $usuario->username = $request->input('username');
        $usuario->email = $request->input('email');
        $usuario->contrasena = \Illuminate\Support\Facades\Hash::make($request->input('contraseña'));
        $usuario->fecha_registro = now();
        $usuario->save();    

        return redirect()->route('games')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }
}
