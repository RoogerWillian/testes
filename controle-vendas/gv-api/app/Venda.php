<?php

namespace App;

use App\Observers\VendaObserver;
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
        return DB::table("vendas")
            ->join("vendedores", "vendas.vendedor_id", "vendedores.id")
            ->where("vendedor_id", $vendedor_id)
            ->get(self::$colunas_retorno);
    }
}
