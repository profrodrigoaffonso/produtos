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

    public static function buscaUuid($uuid){
        return self::where('uuid', $uuid)->first();
    }
}
