<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use App\Helpers\Helpers;

class ProdutoController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->tipo <> 'Admin'){
            return redirect('/logout');
        }
        $produtos = Produto::lista(array('produtos.id','produtos.uuid','produtos.nome','categorias.nome AS categoria'), 'produtos.nome', 'ASC', 20);
        return view('admin.produtos.index', compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->tipo <> 'Admin'){
            return redirect('/logout');
        }
        $categoriasCombo = Categoria::comboCategorias();
        return view('admin.produtos.create', compact('categoriasCombo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dados = $request->all();
        $dados['uuid'] = sha1(uniqid());
        $dados = Helpers::formataBase($dados);
        $dados['valor'] = Helpers::formataValor($dados['valor'],'.');
        Produto::create($dados);
        return redirect(route('admin.produto.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
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
        $produto = Produto::buscaUuid($uuid);
        $categoriasCombo = Categoria::comboCategorias();
        return view('admin.produtos.edit', compact('produto','categoriasCombo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $dados = $request->all();
        $produto = Produto::buscaUuid($dados['uuid']);
        $dados = Helpers::formataBase($dados);
        $dados['id'] = $produto->id;
        $dados['valor'] = Helpers::formataValor($dados['valor'],'.');
        $produto->update($dados);
        return redirect(route('admin.produto.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        //
    }
}
