<?php

namespace App\Http\Controllers;

use App\LogEnvioEmail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class RelatorioController extends Controller
{
    public function enviarEmailVendasDiarios(Request $request)
    {
        $email = $request->get("email");

        try {
            if (isset($email) and !empty($email)) {
                $retorno = Artisan::call("service:email_vendas", [
                    "email" => $email
                ]);

                return response()->json($retorno);
            }
        } catch (\Exception $exception) {
            $retorno = $exception->getMessage();
            return response()->json($retorno);
        }
    }

    public function listar()
    {
        return response()->json(LogEnvioEmail::all(), Response::HTTP_CREATED);
    }
}
