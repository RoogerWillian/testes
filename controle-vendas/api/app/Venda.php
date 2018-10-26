<?php

namespace App;

use App\Observers\VendaObserver;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $fillable = ['valor', 'comissao', 'vendedor_id'];
    protected $dispatchesEvents = [
        'created' => VendaObserver::class,
    ];
    protected $defaults = array(
        "comissao" => 0.00
    );

    public function __construct(array $attributes = array())
    {
        $this->setRawAttributes($this->defaults, true);
        parent::__construct($attributes);
    }

    public function vendedor()
    {
        return $this->belongsTo('App\Vendedor', 'vendedor_id');
    }


}
