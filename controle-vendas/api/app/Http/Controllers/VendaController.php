<?php

namespace App\Http\Controllers;

use App\Venda;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class VendaController extends Controller
{
    protected function validarVenda(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendedor_id' => 'required|integer',
            'valor' => 'required|numeric|min:0.01|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/'
        ]);

        return $validator;
    }

    public function lancar(Request $request)
    {
        // Validando dados
        $validator = $this->validarVenda($request);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Dados invalidos',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $data_to_save = $request->only(["vendedor_id", "valor"]);

        try {
            if ($data_to_save) {
                $venda = Venda::create($data_to_save);
                if ($venda) {
                    $venda_retorno = new \stdClass();
                    $venda_retorno->id = $venda->id;
                    $venda_retorno->nome = $venda->vendedor->nome;
                    $venda_retorno->email = $venda->vendedor->email;
                    $venda_retorno->comissao_atual_vendedor = $this->formatar_moeda($venda->vendedor->comissao);
                    $venda_retorno->valor_da_venda = $this->formatar_moeda($venda->valor);
                    $venda_retorno->data_da_venda = date('d/m/Y H:i:s', strtotime($venda->created_at));
                    $venda_retorno->comissao_venda = $this->formatar_moeda($venda->comissao);

                    return response()->json([
                        "message" => "Venda lancada com sucesso", "data" => $venda_retorno], Response::HTTP_CREATED);
                } else {
                    return response()->json(["message" => "Erro ao lançar venda"], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json(["message" => "vendodor_id e valor sao obrigatorios"], Response::HTTP_BAD_REQUEST);
            }

        } catch (\Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function formatar_moeda($valor)
    {
        return number_format($valor, 2, ",", ".");
    }
}
