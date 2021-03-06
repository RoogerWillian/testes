<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vendedor extends Model
{
    protected $table = "vendedores";
    protected $fillable = ["nome", "email"];
    private static $colunas_retorno = ["id", "nome", "email", "comissao"];
    private static $colunas_formatadas = ["vendedores.id AS vendedores_id", "vendedores.nome", "vendedores.email", "vendedores.comissao"];

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

    public static function vendedores_com_vendas()
    {
        return DB::table("vendedores")
            ->get(self::$colunas_formatadas);
    }

}
