<?php

namespace App\Http\Controllers;

use App\Vendedor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class VendedorController extends Controller
{

    protected function validarVendedor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'email' => 'required|email'
        ]);

        return $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendedores = Vendedor::all(["id", "nome", "email", "comissao"]);

        return response()->json(['vendedores' => $vendedores], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validando dados
        $validator = $this->validarVendedor($request);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Dados invalidos',
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $data = $request->only(['nome', 'email']);

        try {
            if ($data) {
                $vendedor = Vendedor::create($data);
                if ($vendedor) {
                    $dados_retorno = new \stdClass();
                    $dados_retorno->id = $vendedor->id;
                    $dados_retorno->nome = $vendedor->nome;
                    $dados_retorno->email = $vendedor->email;
                    return response()->json([
                        "message" => "Vendedor salvo com sucesso", "data" => $dados_retorno], Response::HTTP_CREATED);
                } else
                    return response()->json(["message" => "Erro ao criar vendedor"], Response::HTTP_BAD_REQUEST);
            } else {
                return response()->json(["message" => "Nome e Email sao obrigatorios"], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
