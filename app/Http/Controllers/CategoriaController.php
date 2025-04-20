<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Helpers\Helpers;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->tipo <> 'Admin'){
            return redirect('/logout');
        }
        $categorias = Categoria::lista(array('id','uuid','nome'), 'nome', 'ASC', 20);
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->all();
        $dados['uuid'] = sha1(uniqid());
        $dados = Helpers::formataBase($dados);
        Categoria::create($dados);
        return redirect(route('admin.categoria.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        if(Auth::user()->tipo <> 'Admin'){
            return redirect('/logout');
        }
        $categoria = Categoria::buscaUuid($uuid);
        return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $dados = $request->all();
        $categoria = Categoria::buscaUuid($dados['uuid']);
        $dados['id'] = $categoria->id;
        $dados = Helpers::formataBase($dados);
        $categoria->update($dados);
        return redirect(route('admin.categoria.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        //
    }
}
