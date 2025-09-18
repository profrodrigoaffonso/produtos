<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    /** @use HasFactory<\Database\Factories\CompraFactory> */
    use HasFactory;

    protected $fillable = ['cliente_id', 'uuid', 'valor', 'forma_pagamento_id', 'data_vencimento', 'data_pagamento'];
}
