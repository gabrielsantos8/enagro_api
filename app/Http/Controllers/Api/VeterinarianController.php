<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Veterinarian;
use App\Services\CrmvService;
use App\Utils\SqlGetter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VeterinarianController extends Controller
{
    public function list()
    {
        $veterinarians = DB::table('veterinarians')
            ->join('users', 'users.id', '=', 'veterinarians.user_id')
            ->join('situations', 'situations.id', '=', 'veterinarians.situation_id')
            ->select('veterinarians.*', 'users.name as user', 'situations.description as situation')
            ->get();

        foreach ($veterinarians as $key => $value) {
            $haveData = DB::select("SELECT 1 FROM activations WHERE veterinarian_id = {$veterinarians[$key]->id}");
            $veterinarians[$key]->isNotDeletable = isset($haveData[0]);
        }

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
                $veterinarian->situation_id = $request->situation_id ?? 1;
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
            ->join('situations', 'situations.id', '=', 'veterinarians.situation_id')
            ->select('veterinarians.*', 'users.name as user', 'situations.description as situation')
            ->where('veterinarians.id', '=', $id)
            ->get();
        foreach ($veterinarian as $key => $value) {
            $haveData = DB::select("SELECT 1 FROM activations WHERE veterinarian_id = {$veterinarian[$key]->id}");
            $veterinarian[$key]->isNotDeletable = isset($haveData[0]);
        }
        return response()->json(['success' => true, 'message' => "", "dados" => $veterinarian], !empty($veterinarian) ? 200 : 404);
    }

    public function update(Request $request)
    {
        try {
            $crmvService = new CrmvService();
            $data = $crmvService->validate($request->uf, $request->name, $request->crmv, $request->idcrmv);
            if (!empty($data)) {
                $dados = $request->except('id');
                $dados['nome'] = $dados['name'];
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

    public function getByServicesAndCities(string $services_id, string $animals_id)
    {
        try {
            $servicesId = explode(',', $services_id);
            $retCities = DB::select('SELECT
                                        ad.city_id 
                                    FROM animals a
                                    LEFT JOIN user_addresses ad on ad.id = a.user_address_id
                                    WHERE a.id in (?)', [$animals_id]);

            $ret = DB::select("SELECT
                                    tb.*
                                FROM (
                                
                                
                                SELECT
                                    v.*
                                    ,u.image_url
                                    ,count(distinct vs.service_id) as service_count
                                    ,count(distinct sc.city_id)  as city_count
                                FROM veterinarians v
                                LEFT JOIN veterinarian_services vs on vs.veterinarian_id = v.id
                                LEFT JOIN service_cities sc on sc.veterinarian_id = v.id
                                LEFT JOIN users u on u.id = v.user_id
                                LEFT JOIN situations s on s.id = v.situation_id
                                WHERE vs.service_id in (" . $services_id . ")
                                AND sc.city_id in (
                                                        SELECT
                                                            ad.city_id 
                                                        FROM animals a
                                                        LEFT JOIN user_addresses ad on ad.id = a.user_address_id
                                                        WHERE a.id in (" . $animals_id . "))
                                AND NOT v.user_id in (
                                    SELECT
                                        ad.user_id
                                    FROM animals a
                                    LEFT JOIN user_addresses ad on ad.id = a.user_address_id
                                        WHERE a.id in (" . $animals_id . ")
                                )
                                GROUP BY 1,2,3,4,5,6,7,8,9,10,11,12
                                    
                                ) tb
                                WHERE tb.service_count = " . count($servicesId) . "
                                  and tb.city_count  = " . count($retCities) . "
            ");
            return response()->json(['success' => true, 'message' => '', 'dados' => $ret], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getBy(string $field, $value)
    {
        $veterinarian = DB::table('veterinarians')
            ->join('users', 'users.id', '=', 'veterinarians.user_id')
            ->join('situations', 'situations.id', '=', 'veterinarians.situation_id')
            ->select('veterinarians.*', 'users.name as user', 'situations.description as situation')
            ->where([['veterinarians.' . $field, '=', $value]])
            ->get();

        foreach ($veterinarian as $key => $value) {
            $haveData = DB::select("SELECT 1 FROM activations WHERE veterinarian_id = {$veterinarian[$key]->id}");
            $veterinarian[$key]->isNotDeletable = isset($haveData[0]);
        }
        return $veterinarian;
    }
}
