<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    /** @use HasFactory<\Database\Factories\CarrinhoFactory> */
    use HasFactory;

    protected $fillable = ['produto_id', 'cliente_id', 'quantidade', 'valor_unitario', 'valor', 'ip'];

    public static function atualizaDataCarrinho() {
        self::where('cliente_id', session('cliente')->id)
                ->update(['updated_at' => date('Y-m-d H:i:s')]);
    }

    public static function atualizaDataCarrinhoIp() {
        self::where('ip', $_SERVER['REMOTE_ADDR'])
                ->update(['updated_at' => date('Y-m-d H:i:s')]);
    }

}
