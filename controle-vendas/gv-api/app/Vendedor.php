<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vendedor extends Model
{
    protected $table = "vendedores";
    protected $fillable = ["nome", "email"];
    private static $colunas_retorno = ["id", "nome", "email", "comissao"];

    public static function buscar($filtro)
    {
        if (isset($filtro) and !empty($filtro)) {
            $vendedores = DB::table("vendedores")
                ->where("nome", "like", "%{$filtro}%")
                ->get(self::$colunas_retorno);
        } else {
            $vendedores = DB::table("vendedores")->get(self::$colunas_retorno);
        }

        return $vendedores;
    }
}
