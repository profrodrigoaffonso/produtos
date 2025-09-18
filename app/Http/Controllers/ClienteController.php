<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{

    public function logout()
    {
        Auth::guard('cliente')->logout();
        return redirect('/login'); // ou qualquer rota desejada
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->tipo <> 'Admin'){
            return redirect('/logout');
        }
        return view('admin.clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->all();
        $dados['tipo']          = 'Cliente';
        $dados['name']          = $dados['nome'];
        $dados                  = Helpers::formataBase($dados);
        $dados['password']      = Hash::make($dados['password']);
        $user                   = User::create($dados);
        $dados['user_id']       = $user->id;
        $dados['uuid']          = sha1(uniqid());
        Cliente::create($dados);
        return redirect(route('admin.categoria.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        //
    }
}
