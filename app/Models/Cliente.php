<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Cliente extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\ClienteFactory> */
    use HasFactory;

    protected $fillable = ['uuid', 'nome', 'email', 'password'];

}
