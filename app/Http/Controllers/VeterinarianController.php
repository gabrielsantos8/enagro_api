<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CrmvController;
use App\Http\Interfaces\WebInteface;
use App\Models\Veterinarian;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VeterinarianController extends Controller implements WebInteface
{

    public function index($err = "") {
        return view('veterinarian.index', ['dados' => $this->list()->getData()->dados, "error" => $err]);
    }

    public function create($err = "") {
        $cityController = new CityController();
        $query = "SELECT 
                        u.*
                  FROM users u 
                  WHERE NOT EXISTS (select 1 from veterinarians v where v.user_id = u.id)";
        $users = DB::select($query);
        return view('veterinarian.create', ['users' => $users, 'ufs' => $cityController->getUfs()->getData()->dados, 'error' => $err]);
    }

    public function edit(int $id) {

    }

    public function webStore(Request $req) {
        $ret = $this->store($req)->getData();
        if($ret->success) {
            return $this->index();
        }
        return $this->create($ret->message);
    }

    public function webUpdate(Request $req) {

    }

    public function webDestroy(Request $req) {
        $ret = $this->destroy($req)->getData();
        if ($ret->success) {
            return $this->index();
        }
        return $this->index($ret->message);
    }


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
            $dados = $request->except('id');
            $veterinarian = Veterinarian::find($request->id);
            $veterinarian->update($dados);
            return response()->json(['success' => true, 'message' => 'Veterinário atualizado!'], 200);
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
        ->where('veterinarians.'.$field, '=', $value)
        ->get();
        return $veterinarian;
    }
}