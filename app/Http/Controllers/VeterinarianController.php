<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CrmvController;
use App\Models\Veterinarian;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VeterinarianController extends Controller
{

    public function list()
    {
        $veterinarians = DB::table('veterinarians')
            ->join('users', 'users.id', '=', 'veterinarians.user_id')
            ->select('veterinarians.*', 'users.name as user')
            ->get();
        return response()->json(['success' => true, 'message' => "", "dados" => $veterinarians], 200);
    }


    public function store(Request $request)
    {
        try {
            $crmvService = new CrmvController();
            $dados = $crmvService->validate($request->uf, $request->name, $request->crmv, $request->idcrmv);
            die;


            $veterinarian = new Veterinarian();
            // $veterinarian->id_pf_inscricao;
            // $veterinarian->pf_inscricao;
            // $veterinarian->pf_uf;
            // $veterinarian->nome;
            // $veterinarian->nome_social;
            // $veterinarian->atuante;
            // $veterinarian->user_id;
            if ($veterinarian->save()) {
                return response()->json(['success' => true, 'message' => "Endereço cadastrado!", 'dados' => $veterinarian], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    private function validateCRMV(Request $request) {

    }


    public function show(string $id)
    {
        $veterinarian = DB::table('veterinarians')
            ->join('users', 'users.id', '=', 'veterinarians.user_id')
            ->select('veterinarians.*', 'users.name as user')
            ->where('veterinarians', '=', $id)
            ->get();
        return response()->json(['success' => true, 'message' => "", "dados" => $veterinarian], !empty($veterinarian) ? 200 : 404);
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
