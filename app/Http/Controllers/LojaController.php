<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produto;
use App\Helpers\Helpers;


class LojaController extends Controller
{
    public function index() {
        $combo = Helpers::valoresNumericosCombo(1, 20);
        $produtos = Produto::lista(array('produtos.id', 'produtos.valor', 'produtos.uuid', 'produtos.nome', 'categorias.nome AS categoria'));
        return view('loja.index', compact('produtos', 'combo'));
    }

    public function detalhes($uuid) {
        $produto = Produto::detalhes($uuid);
        if(!$produto) {
            return redirect(route('loja.index'));
        }
        $combo = Helpers::valoresNumericosCombo(1, 20);
        return view('loja.detalhes', compact('produto', 'combo'));
    }
}
