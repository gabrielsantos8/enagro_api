<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Veterinarian;
use App\Services\CrmvService;
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
            $crmvService = new CrmvService();
            $data = $crmvService->validate($request->uf, $request->name, $request->crmv, $request->idcrmv);
            if (!empty($data)) {
                $veterinarian = new Veterinarian();
                $veterinarian->id_pf_inscricao = intval($data->id_pf_inscricao);
                $veterinarian->pf_inscricao = intval($data->pf_inscricao);
                $veterinarian->pf_uf = $data->pf_uf;
                $veterinarian->nome = $data->nome;
                $veterinarian->nome_social = $data->nome_social ?? '';
                $veterinarian->atuante = $data->atuante ? 1 : 0;
                $veterinarian->user_id = $request->user_id;
                if ($veterinarian->save()) {
                    return response()->json(['success' => true, 'message' => "Veterinário cadastrado!", 'dados' => $veterinarian], 200);
                }
            }
            return response()->json(['success' => false, 'message' => 'Veterinário não identificado'], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    public function show(string $id)
    {
        $veterinarian = DB::table('veterinarians')
            ->join('users', 'users.id', '=', 'veterinarians.user_id')
            ->select('veterinarians.*', 'users.name as user')
            ->where('veterinarians.id', '=', $id)
            ->get();
        return response()->json(['success' => true, 'message' => "", "dados" => $veterinarian], !empty($veterinarian) ? 200 : 404);
    }

    public function update(Request $request)
    {
        try {
            $crmvService = new CrmvService();
            $data = $crmvService->validate($request->uf, $request->name, $request->crmv, $request->idcrmv);
            if (!empty($data)) {
                $dados = $request->except('id');
                $veterinarian = Veterinarian::find($request->id);
                $veterinarian->update($dados);
                return response()->json(['success' => true, 'message' => 'Veterinário atualizado!'], 200);
            }
            return response()->json(['success' => false, 'message' => 'Veterinário não identificado'], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $veterinarian = Veterinarian::find($request->id);
            $veterinarian->delete();
            return response()->json(['success' => true, 'message' => "Veterinário excluído!"], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByUser(int $id)
    {
        $veterinarian = $this->getBy('user_id', $id);
        return response()->json(['success' => true, 'message' => "", "dados" => $veterinarian], count($veterinarian) >= 1 ? 200 : 404);
    }

    public function getBy(string $field, $value)
    {
        $veterinarian = DB::table('veterinarians')
            ->join('users', 'users.id', '=', 'veterinarians.user_id')
            ->select('veterinarians.*', 'users.name as user')
            ->where('veterinarians.' . $field, '=', $value)
            ->get();
        return $veterinarian;
    }
}