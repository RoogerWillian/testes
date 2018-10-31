<?php

namespace App;

use App\Observers\VendaObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Venda extends Model
{
    protected $fillable = ['valor', 'comissao', 'vendedor_id'];
    protected $dispatchesEvents = [
        'created' => VendaObserver::class,
    ];
    protected $defaults = array(
        "comissao" => 0.00
    );
    private static $colunas_retorno = [
        "vendas.id", "vendedores.nome", "vendedores.email", "vendedores.comissao AS comissao_vendedor",
        "vendas.comissao AS comissao_venda", "vendas.valor", "vendas.created_at as data"
    ];

    public function __construct(array $attributes = array())
    {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

    public function vendedor()
    {
        return $this->belongsTo('App\Vendedor', 'vendedor_id');
    }

    public static function por_vendedor($vendedor_id)
    {
        if ($vendedor_id) {
            $vendas = DB::table("vendas")
                ->join("vendedores", "vendas.vendedor_id", "vendedores.id")
                ->where("vendedor_id", $vendedor_id)
                ->get(self::$colunas_retorno);
        } else {
            $vendas = DB::table("vendas")
                ->join("vendedores", "vendas.vendedor_id", "vendedores.id")
                ->get(self::$colunas_retorno);
        }

        return $vendas;
    }

    public static function vendas_do_dia()
    {
        $hoje = Carbon::now()->format('Y-m-d');
        $dt_inicial = $hoje . " 00:00:00";
        $dt_final = $hoje . " 23:59:59";

        return \DB::table("vendas")
            ->join("vendedores", "vendas.vendedor_id", "vendedores.id")
            ->whereBetween("vendas.created_at", [$dt_inicial, $dt_final])
            ->get(self::$colunas_retorno);
    }

    public static function somar_vendas_do_dia()
    {
        $hoje = Carbon::now()->format('Y-m-d');
        $dt_inicial = $hoje . " 00:00:00";
        $dt_final = $hoje . " 23:59:59";

        return \DB::table("vendas")
            ->join("vendedores", "vendas.vendedor_id", "vendedores.id")
            ->whereBetween("vendas.created_at", [$dt_inicial, $dt_final])
            ->sum('valor');
    }

    public static function somar_comissao_vendas_do_dia()
    {
        $hoje = Carbon::now()->format('Y-m-d');
        $dt_inicial = $hoje . " 00:00:00";
        $dt_final = $hoje . " 23:59:59";

        return \DB::table("vendas")
            ->join("vendedores", "vendas.vendedor_id", "vendedores.id")
            ->whereBetween("vendas.created_at", [$dt_inicial, $dt_final])
            ->sum('vendas.comissao');
    }
}
