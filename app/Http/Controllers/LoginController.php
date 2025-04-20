<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Cliente;
use App\Models\Admin;

class LoginController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if(Auth::user()->tipo == 'Admin'){
                $admin = Admin::porUserId(Auth::user()->id);
                session(['admin' => $admin]);
                return redirect(route('admin.produto.index'));
            } else {
                $cliente = Cliente::porUserId(Auth::user()->id);
                session(['cliente' => $cliente]);
                return redirect(route('loja.index'));
            }
        }

        return back()->withErrors([
            'password' => 'Usuário e ou senha inválidos.',
        ]);
    }


    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


}
