<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class RelatorioController extends Controller
{
    public function enviarEmailVendasDiarios(Request $request)
    {
        $email = $request->get("email");

        try {
            if (isset($email) and !empty($email)) {
                $retorno = Artisan::call("servico:email_vendas", [
                    "email" => $email
                ]);

                return response()->json($retorno);
            }
        } catch (\Exception $exception) {
            $retorno = $exception->getMessage();
            return response()->json($retorno);
        }
    }
}
