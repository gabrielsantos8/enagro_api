<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthPlanContract;
use App\Services\PaymentService;
use App\Services\SignatureService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HealthPlanContractController extends Controller
{
    public function list()
    {
        $healthPlanContracts = DB::table('health_plan_contracts')
            ->leftJoin('users', 'health_plan_contracts.user_id', '=', 'users.id')
            ->leftJoin('health_plans', 'health_plan_contracts.health_plan_id', '=', 'health_plans.id')
            ->leftJoin('health_plan_contract_types', 'health_plan_contracts.health_plan_contract_type_id', '=', 'health_plan_contract_types.id')
            ->leftJoin('health_plan_contract_status', 'health_plan_contracts.health_plan_contract_status_id', '=', 'health_plan_contract_status.id')
            ->select(
                'health_plan_contracts.*',
                'users.name as user',
                'health_plans.description as plan',
                'health_plans.detailed_description as plan_detailed_description',
                'health_plans.value as plan_value',
                'health_plans.minimal_animals as plan_minimal_animals',
                'health_plans.maximum_animals as plan_maximum_animals',
                'health_plans.plan_colors',
                'health_plan_contract_types.description as type',
                'health_plan_contract_status.description as status'
            )
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $healthPlanContracts], 200);
    }

    public function show(string $id)
    {
        $healthPlanContract = DB::table('health_plan_contracts')
            ->leftJoin('users', 'health_plan_contracts.user_id', '=', 'users.id')
            ->leftJoin('health_plans', 'health_plan_contracts.health_plan_id', '=', 'health_plans.id')
            ->leftJoin('health_plan_contract_types', 'health_plan_contracts.health_plan_contract_type_id', '=', 'health_plan_contract_types.id')
            ->leftJoin('health_plan_contract_status', 'health_plan_contracts.health_plan_contract_status_id', '=', 'health_plan_contract_status.id')
            ->select(
                'health_plan_contracts.*',
                'users.name as user',
                'health_plans.description as plan',
                'health_plans.detailed_description as plan_detailed_description',
                'health_plans.value as plan_value',
                'health_plans.minimal_animals as plan_minimal_animals',
                'health_plans.maximum_animals as plan_maximum_animals',
                'health_plans.plan_colors',
                'health_plan_contract_types.description as type',
                'health_plan_contract_status.description as status'
            )
            ->where([['health_plan_contracts.id', '=', $id]])
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $healthPlanContract], !empty($healthPlanContract) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $healthPlanContract = new HealthPlanContract();
            $healthPlanContract->health_plan_id = $request->health_plan_id;
            $healthPlanContract->user_id = $request->user_id;
            $healthPlanContract->health_plan_contract_type_id = $request->health_plan_contract_type_id;
            $healthPlanContract->health_plan_contract_status_id = $request->health_plan_contract_status_id;
            $healthPlanContract->value = $this->calcContractValue($request->health_plan_contract_type_id, $request->value);
            $healthPlanContract->save();
            return response()->json(['success' => true, 'message' => '', 'dados' => $healthPlanContract], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function calcContractValue($type, $value)
    {
        return $type == 1 ? $value : $value * 12;
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $healthPlanContract = HealthPlanContract::find($request->id);
            $healthPlanContract->update($dados);
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $healthPlanContract = HealthPlanContract::find($request->id);
            $healthPlanContract->delete();
            return response()->json(['success' => true, 'message' => ""], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByUser(int $id)
    {
        $healthPlanContract = $this->getBy([['health_plan_contracts.user_id', '=', $id]]);
        return response()->json(['success' => true, 'message' => "", "dados" => $healthPlanContract], count($healthPlanContract) >= 1 ? 200 : 404);
    }

    public function getActiveContractByUser(int $id)
    {
        $healthPlanContract = $this->getBy([['health_plan_contracts.user_id', '=', $id], ['health_plan_contracts.health_plan_contract_status_id', '=', 1]]);
        return response()->json(['success' => true, 'message' => "", "dados" => isset($healthPlanContract[0]) ? $healthPlanContract[0] : json_decode('{}')], 200);
    }

    public function getBy(array $wheres)
    {
        $servicesController = new HealthPlanServiceController();
        $healthPlanContract = DB::table('health_plan_contracts')
            ->leftJoin('users', 'health_plan_contracts.user_id', '=', 'users.id')
            ->leftJoin('health_plans', 'health_plan_contracts.health_plan_id', '=', 'health_plans.id')
            ->leftJoin('health_plan_contract_types', 'health_plan_contracts.health_plan_contract_type_id', '=', 'health_plan_contract_types.id')
            ->leftJoin('health_plan_contract_status', 'health_plan_contracts.health_plan_contract_status_id', '=', 'health_plan_contract_status.id')
            ->select(
                'health_plan_contracts.*',
                'users.name as user',
                'health_plans.description as plan',
                'health_plans.detailed_description as plan_detailed_description',
                'health_plans.value as plan_value',
                'health_plans.minimal_animals as plan_minimal_animals',
                'health_plans.maximum_animals as plan_maximum_animals',
                'health_plans.plan_colors',
                'health_plan_contract_types.description as type',
                'health_plan_contract_status.description as status'
            )
            ->where($wheres)
            ->get();

        foreach ($healthPlanContract as $key => $value) {
            $services = $servicesController->getByHealthPlan($value->health_plan_id)->getData()->dados;
            $healthPlanContract[$key]->services = $services;
        }

        return $healthPlanContract;
    }


    public function contractSign(Request $req)
    {
        try {
            $service = new SignatureService();
            $ret = $service->startSign($req);
            return response()->json(['success' => true, 'message' => '', 'dados' => $ret], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function installmentPayment(Request $req)
    {
        try {
            $service = new PaymentService();
            $ret = $service->installmentPayment($req);
            return response()->json(['success' => true, 'message' => '', 'dados' => $ret], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
