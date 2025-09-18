<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
    /** @use HasFactory<\Database\Factories\ClienteFactory> */
    use HasFactory;

    protected $fillable = ['uuid', 'nome', 'email', 'user_id'];

    public static function porUserId($user_id){
        return self::where('user_id', $user_id)->first();
    }

}
