<?php
namespace App\Helpers;

class Helpers
{
    public static function formataValor($valor, $separador = '.'){
        $valor = preg_replace('/\D/', '', $valor);
        return number_format($valor / 100, 2, $separador, '');
    }

    public static function maiscula($texto){
        return mb_strtoupper($texto);
    }

    public static function formataBase($dados){
        $excecoes = array('uuid','foto','url','password');
        $minusculas = array('email');
        foreach($dados as $key => $dado){
            if(!in_array($key, $excecoes)){
                if(in_array($key, $minusculas)){
                    $dados[$key] = mb_strtolower($dados[$key]);
                } else {
                    $dados[$key] = mb_strtoupper($dados[$key]);
                }
            }
        }
        return $dados;
    }
}

