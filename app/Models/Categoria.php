<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    /** @use HasFactory<\Database\Factories\CategoriaFactory> */
    use HasFactory;

    protected $fillable = ['uuid', 'nome'];

    public static function lista($campos = array(), $ordem = 'id', $tipo_ordem = 'ASC', $paginacao = 10, $filtro = null) {

        return self::select($campos)->orderBy($ordem, $tipo_ordem)->paginate(10);

    }

    public static function buscaUuid($uuid){
        return self::where('uuid', $uuid)->first();
    }

    public static function comboCategorias(){
        return self::pluck('nome', 'id');
    }

}
