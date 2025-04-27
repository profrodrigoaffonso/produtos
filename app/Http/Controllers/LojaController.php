<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Helpers\Helpers;

use App\Models\Produto;
use App\Models\Carrinho;
use App\Models\Compra;
use App\Models\CompraProduto;
use App\Models\FormaPagamento;

class LojaController extends Controller
{

    public function limparCarrinho() {
        Carrinho::where('updated_at', '<',  Carbon::now()->subMinutes(15))->delete();
    }

    public function index() {
        $combo = Helpers::valoresNumericosCombo(1, 20);
        $produtos = Produto::lista(array('produtos.id', 'produtos.valor', 'produtos.uuid', 'produtos.nome', 'categorias.nome AS categoria'));

        if(session('cliente')){
            Carrinho::where('ip', $_SERVER['REMOTE_ADDR'])
                    ->where('cliente_id', null)
                    ->update(['cliente_id' => session('cliente')->id]);
            Carrinho::atualizaDataCarrinho();
        } else {
            Carrinho::atualizaDataCarrinhoIp();
        }
        return view('loja.index', compact('produtos', 'combo'));
    }

    public function detalhes($uuid) {
        // dd(session('cliente')->uuid);
        $produto = Produto::detalhes($uuid);
        if(!$produto) {
            return redirect(route('loja.index'));
        }
        $combo = Helpers::valoresNumericosCombo(1, 20);
        return view('loja.detalhes', compact('produto', 'combo'));
    }

    public function adicionar($uuid, $quantidade){

        $produto = Produto::buscaUuid($uuid);

        if(session('cliente')){

            $carrinho = Carrinho::where('cliente_id', session('cliente')->id)
                                ->where('produto_id', $produto->id)
                                ->first();

            if($carrinho){
                $dados = array(
                    'quantidade'        => (int)$quantidade,
                    'valor_unitario'    => $produto->valor,
                    'valor'             => (int)$quantidade * $produto->valor,
                    'ip'                => $_SERVER['REMOTE_ADDR']
                );
                $carrinho->update($dados);
            } else {
                $dados = array(
                    'cliente_id'        => session('cliente')->id,
                    'produto_id'        => $produto->id,
                    'quantidade'        => (int)$quantidade,
                    'valor_unitario'    => $produto->valor,
                    'valor'             => (int)$quantidade * $produto->valor,
                    'ip'                => $_SERVER['REMOTE_ADDR']
                );
                Carrinho::create($dados);
            }
            Carrinho::atualizaDataCarrinho();
        } else {
            $carrinho = Carrinho::where('ip', $_SERVER['REMOTE_ADDR'])
                                ->where('produto_id', $produto->id)
                                ->first();

            if($carrinho){
                $dados = array(
                    'quantidade' => (int)$quantidade,
                    'valor_unitario'    => $produto->valor,
                    'valor'      => (int)$quantidade * $produto->valor,
                    'ip'         => $_SERVER['REMOTE_ADDR']
                );
                $carrinho->update($dados);
            } else {
                $dados = array(
                    'produto_id' => $produto->id,
                    'quantidade' => (int)$quantidade,
                    'valor_unitario'    => $produto->valor,
                    'valor'      => (int)$quantidade * $produto->valor,
                    'ip'         => $_SERVER['REMOTE_ADDR']
                );
                Carrinho::create($dados);
            }

        }

    }

    public function carrinho() {

        if(session('cliente')){
            $carrinhos = Carrinho::select('carrinhos.id', 'carrinhos.valor', 'carrinhos.quantidade', 'produtos.nome AS produto')
                                ->where('cliente_id', session('cliente')->id)
                                ->join('produtos', 'produto_id', '=', 'produtos.id')
                                ->get();
            Carrinho::atualizaDataCarrinho();
            $logado = true;
        } else {
            $carrinhos = Carrinho::select('carrinhos.id', 'carrinhos.valor', 'carrinhos.quantidade', 'produtos.nome AS produto')
                                ->join('produtos', 'produto_id', '=', 'produtos.id')
                                ->where('cliente_id', null)
                                ->get();
            Carrinho::atualizaDataCarrinhoIp();
            $logado = false;
        }

        return view('loja.carrinho.index', compact('carrinhos', 'logado'));

    }

    public function store(Request $request) {
        if(!session('cliente')){
            die;
        }
        // dd(session('cliente')->id);
        try {
            DB::beginTransaction();
            $compra = Compra::create([
                'cliente_id' => session('cliente')->id,
                'uuid'      => sha1(uniqid())
            ]);

            $carrinhos = Carrinho::select('carrinhos.id', 'carrinhos.valor', 'carrinhos.valor_unitario', 'carrinhos.produto_id', 'carrinhos.quantidade')
                                ->where('cliente_id', session('cliente')->id)
                                ->get();


            $total = 0;

            foreach($carrinhos as $carrinho){

                $item = array(
                    'compra_id'         => $compra->id,
                    'produto_id'        => $carrinho->produto_id,
                    'valor_unitario'    => $carrinho->valor_unitario,
                    'valor'             => $carrinho->valor,
                    'quantidade'        => $carrinho->quantidade,
                );

                CompraProduto::create($item);

                $total += $carrinho->valor;

            }
            $compra->update([
                'valor' => $total
            ]);

            Carrinho::where('cliente_id', session('cliente')->id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // Logar erro, lançar exceção ou lidar de outra forma
            throw $e;
        }
        return redirect(route('loja.checkout', $compra->uuid));

    }

    public function checkout($uuid) {
        if(!session('cliente')){
            die;
        }
        $compra = Compra::where('cliente_id', session('cliente')->id)
                        ->where('compras.uuid', $uuid)
                        ->where('data_vencimento', null)
                        ->first();

        $produtos = CompraProduto::select('compra_produtos.id', 'produtos.nome AS produto', 'compra_produtos.quantidade',
                                          'compra_produtos.valor')
                                  ->join('produtos', 'compra_produtos.produto_id', '=', 'produtos.id')
                                  ->where('compra_produtos.compra_id', $compra->id)
                                  ->get();

        $forma_pagamentos = FormaPagamento::orderBy('nome', 'ASC')->pluck('nome', 'id');

        return view('loja.checkout', compact('produtos', 'forma_pagamentos', 'uuid'));


    }

    public function finalizar($uuid, Request $request) {
        if(!session('cliente')){
            die;
        }
        $compra = Compra::where('cliente_id', session('cliente')->id)
                        ->where('compras.uuid', $uuid)
                        ->where('data_vencimento', null)
                        ->first();

        if($compra){
            $dados = $request->all();
            $dados['data_vencimento'] = date('Y-m-d',strtotime('+3 days'));
            $compra->update($dados);
        }
    }
}
