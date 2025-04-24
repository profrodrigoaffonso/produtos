<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraProduto extends Model
{
    /** @use HasFactory<\Database\Factories\CompraProdutoFactory> */
    use HasFactory;

    protected $fillable = ['compra_id', 'produto_id', 'valor_unitario', 'valor', 'quantidade'];
}
