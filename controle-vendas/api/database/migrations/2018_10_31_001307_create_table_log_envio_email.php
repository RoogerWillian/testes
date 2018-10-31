<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLogEnvioEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_envio_email', function (Blueprint $table) {
            $table->increments('id');
            $table->string("descricao", 500);
            $table->enum('tipo', ['RELATORIO_GERAL', 'RELATORIO_VENDEDOR']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_envio_email');
    }
}
