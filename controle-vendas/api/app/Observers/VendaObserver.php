<?php

namespace App\Observers;

use App\Venda;

class VendaObserver
{
    /**
     * Handle the venda "created" event.
     *
     * @param  \App\Venda $venda
     * @return void
     */
    public function created(Venda $venda)
    {
        $comissao_venda = ($venda->valor * 8.5) / 100;

        // Salvando a comissao na venda
        $venda->comissao = $comissao_venda;
        $venda->save();

        // Salvando a comissao no vendedor
        $comissao_atual_vendedor = $venda->vendedor->comissao;
        $comissao_atualizada_vendedor = $comissao_atual_vendedor + $comissao_venda;
        $venda->vendedor->comissao = $comissao_atualizada_vendedor;
        $venda->vendedor->save();
    }

    /**
     * Handle the venda "updated" event.
     *
     * @param  \App\Venda $venda
     * @return void
     */
    public function updated(Venda $venda)
    {
        //
    }

    /**
     * Handle the venda "deleted" event.
     *
     * @param  \App\Venda $venda
     * @return void
     */
    public function deleted(Venda $venda)
    {
        //
    }

    /**
     * Handle the venda "restored" event.
     *
     * @param  \App\Venda $venda
     * @return void
     */
    public function restored(Venda $venda)
    {
        //
    }

    /**
     * Handle the venda "force deleted" event.
     *
     * @param  \App\Venda $venda
     * @return void
     */
    public function forceDeleted(Venda $venda)
    {
        //
    }
}
