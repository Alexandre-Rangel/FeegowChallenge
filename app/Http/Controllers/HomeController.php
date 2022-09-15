<?php

namespace App\Http\Controllers;

use App\Models\Solicitation;
use App\Helpers\Api;
use Illuminate\Http\Request;
use App\Http\Requests\SolicitationRequest;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $tipo = $request->get('tipo');

        $api = new Api();
        return $api->getApi($tipo);
        // return $api->getApi($tipo)->json();
    }

    public function save(SolicitationRequest $request)
    {
        $data = $request->validated();

        $birthdate = implode("-",array_reverse(explode("/",$data['birthdate'])));

        $solicitation = new Solicitation();
        $solicitation->specialty_id = $data['specialty_id'];
        $solicitation->professional_id = $data['professional_id'];
        $solicitation->name = $data['name'];
        $solicitation->cpf = preg_replace("/[^0-9]/", "", $data['cpf']);
        $solicitation->source_id = $data['source_id'];
        $solicitation->birthdate = $birthdate;
        if ($solicitation->save()) {
            return response()->json('Operação realizada com sucesso!', 201);
        }
        return response()->json('Operação não realizada com sucesso!', 400);
    }

}
