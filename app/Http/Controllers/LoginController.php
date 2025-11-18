<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('login'); 
    }
     public function login(Request $request)
    {
        $usuario = Usuarios::where('username', $request->input('username'))->first();
        
        if ($usuario && Hash::check($request->input('contraseña'), $usuario->contrasena)) { 
            Auth::login($usuario);
            $response = redirect('/games');            
        } else {
            session()->flash('error', 'Credenciales inválidas');
            $response = redirect()->back()->withInput();
        }
        return $response; 
    }
} 
    