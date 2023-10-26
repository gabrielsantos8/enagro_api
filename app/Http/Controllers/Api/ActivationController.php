<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activation;
use App\Services\ConActivationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivationController extends Controller
{
    public function list()
    {
        $activations = DB::table('activations')
            ->leftJoin('veterinarians', 'activations.veterinarian_id', '=', 'veterinarians.id')
            ->leftJoin('health_plan_contracts', 'activations.contract_id', '=', 'health_plan_contracts.id')
            ->leftJoin('activation_status', 'activations.activation_status_id', '=', 'activation_status.id')
            ->leftJoin('activation_types', 'activations.activation_type_id', '=', 'activation_types.id')
            ->select('activations.*', 'veterinarians.nome as veterinarian', 'activation_types.description as type', 'activation_status.description as status')
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $activations], 200);
    }

    public function show(string $id)
    {
        $activation = DB::table('activations')
            ->leftJoin('veterinarians', 'activations.veterinarian_id', '=', 'veterinarians.id')
            ->leftJoin('health_plan_contracts', 'activations.contract_id', '=', 'health_plan_contracts.id')
            ->leftJoin('activation_status', 'activations.activation_status_id', '=', 'activation_status.id')
            ->leftJoin('activation_types', 'activations.activation_type_id', '=', 'activation_types.id')
            ->select('activations.*', 'veterinarians.nome as veterinarian', 'activation_types.description as type', 'activation_status.description as status')
            ->where([['activations.id', '=', $id]])
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $activation], !empty($activation) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $activation = new Activation();
            $activation->contract_id = $request->contract_id;
            $activation->veterinarian_id = $request->veterinarian_id;
            $activation->activation_status_id = $request->activation_status_id;
            $activation->activation_type_id = $request->activation_type_id;
            $activation->scheduled_date = $request->scheduled_date;
            $activation->activation_date = $request->activation_date;
            $activation->save();
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $activation = Activation::find($request->id);
            $activation->update($dados);
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $activation = Activation::find($request->id);
            if (isset($activation)) {
                $activation->delete();
            }
            return response()->json(['success' => true, 'message' => ""], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByVeterinarian(int $id)
    {
        $activations = $this->getBy('activations', 'veterinarian_id', $id);
        foreach ($activations as $key => $actv) {
            $activations[$key]->valueToPay = DB::select('SELECT sum(s.value) as value FROM activation_services asv LEFT JOIN services s on s.id = asv.service_id WHERE asv.activation_id = ?', [$actv->id])[0]->value;
            $activations[$key]->services = DB::select('SELECT s.* FROM activation_services asv LEFT JOIN services s on s.id = asv.service_id WHERE asv.activation_id = ?', [$actv->id]);
            $activations[$key]->animals = DB::select('SELECT a.*,ad.complement,ad.city_id,c.description as city,c.uf,c.ibge,att.description as animal_type,ast.description as animal_subtype FROM activation_animals aa LEFT JOIN animals a on a.id = aa.animal_id LEFT JOIN animal_types att on att.id = a.animal_type_id LEFT JOIN animal_subtypes ast on ast.id = a.animal_subtype_id LEFT JOIN user_addresses ad on ad.id = a.user_address_id LEFT JOIN cities c on c.id = ad.city_id WHERE aa.activation_id = ?', [$actv->id]);
            $activations[$key]->addresses = DB::select('SELECT ad.*, c.uf, c.ibge, c.description as city FROM activation_animals aa LEFT JOIN animals a on a.id = aa.animal_id LEFT JOIN user_addresses ad on ad.id = a.user_address_id LEFT JOIN cities c ON c.id = ad.city_id WHERE aa.activation_id = ? GROUP BY 1,2,3,4,5,6,7,8,9', [$actv->id]);
            $activations[$key]->phones = DB::select('SELECT up.* FROM user_phones up WHERE up.user_id = ?', [$actv->user_id]);
        }
        return response()->json(['success' => true, 'message' => "", "dados" => $activations], 200);
    }

    public function getByUser(int $id)
    {
        $activations = $this->getBy('health_plan_contracts', 'user_id', $id);
        foreach ($activations as $key => $actv) {
            $activations[$key]->services = DB::select('SELECT s.* FROM activation_services asv LEFT JOIN services s on s.id = asv.service_id WHERE asv.activation_id = ?', [$actv->id]);
            $activations[$key]->animals = DB::select('SELECT a.* FROM activation_animals aa LEFT JOIN animals a on a.id = aa.animal_id WHERE aa.activation_id = ?', [$actv->id]);
        }
        return response()->json(['success' => true, 'message' => "", "dados" => $activations], 200);
    }

    public function getBy(string $table, string $field, $value)
    {
        $activation =  DB::table('activations')
            ->leftJoin('veterinarians', 'activations.veterinarian_id', '=', 'veterinarians.id')
            ->leftJoin('health_plan_contracts', 'activations.contract_id', '=', 'health_plan_contracts.id')
            ->leftJoin('users', 'health_plan_contracts.user_id', '=', 'users.id')
            ->leftJoin('health_plans', 'health_plan_contracts.health_plan_id', '=', 'health_plans.id')
            ->leftJoin('activation_status', 'activations.activation_status_id', '=', 'activation_status.id')
            ->leftJoin('activation_types', 'activations.activation_type_id', '=', 'activation_types.id')
            ->select('activations.*', 'veterinarians.nome as veterinarian', 'users.name as user', 'users.id as user_id','activation_types.description as type', 'activation_status.description as status', 'health_plans.description as plan')
            ->where([[$table . '.' . $field, '=', $value]])
            ->get();

        return $activation;
    }

    public function findBestVeterinarian(Request $req)
    {
        try {
            $service = new ConActivationService();
            $ret  = $service->findBestVeterinarianForService($req);
            return response()->json(['success' => true, 'message' => '', 'dados' => $ret], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function createActivation(Request $req)
    {
        try {
            $service = new ConActivationService();
            $ret  = $service->createActivation($req);
            return response()->json(['success' => true, 'message' => '', 'dados' => $ret], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
