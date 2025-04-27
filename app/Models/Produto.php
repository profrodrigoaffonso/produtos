<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    /** @use HasFactory<\Database\Factories\ProdutoFactory> */
    use HasFactory;

    protected $fillable = ['uuid', 'categoria_id', 'nome', 'valor'];

    public static function lista($campos = array(), $ordem = 'id', $tipo_ordem = 'ASC', $paginacao = 10, $filtro = null) {

        return self::select($campos)
                    ->join('categorias', 'produtos.categoria_id', '=', 'categorias.id')
                    ->orderBy($ordem, $tipo_ordem)
                    ->paginate(10);

    }

    public static function listaExport(){
        return self::select('produtos.id','produtos.uuid','produtos.valor','produtos.nome','categorias.nome AS categoria')
                    ->join('categorias', 'produtos.categoria_id', '=', 'categorias.id')
                    ->get();
    }

    public static function buscaUuid($uuid){
        return self::where('uuid', $uuid)->first();
    }

    public static function detalhes($uuid){
        return self::select('produtos.id', 'produtos.nome', 'produtos.uuid','produtos.valor', 'categorias.nome AS categoria')
                    ->join('categorias', 'produtos.categoria_id', '=', 'categorias.id')
                    ->where('produtos.uuid', $uuid)
                    ->first();
    }
}
