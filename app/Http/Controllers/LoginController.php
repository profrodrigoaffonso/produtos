<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Cliente;
use App\Models\Admin;
use App\Models\Carrinho;

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
                Carrinho::where('ip', $_SERVER['REMOTE_ADDR'])
                    ->where('cliente_id', null)
                    ->update(['cliente_id' => session('cliente')->id]);
                Carrinho::atualizaDataCarrinho();
                return redirect()->back();
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
        return redirect('/login');
    }


}
