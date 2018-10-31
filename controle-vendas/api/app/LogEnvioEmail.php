<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogEnvioEmail extends Model
{
    protected $table = "log_envio_email";
    protected $fillable = ['descricao', 'tipo'];
}
