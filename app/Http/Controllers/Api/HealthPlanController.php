<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthPlan;
use App\Utils\SqlGetter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HealthPlanController extends Controller
{
    public function list()
    {
        $healthPlans = HealthPlan::all();

        foreach ($healthPlans as $key => $value) {
            $haveData1 = DB::select("SELECT 1 FROM health_plan_services WHERE health_plan_id = {$healthPlans[$key]->id}");
            $haveData2 = DB::select("SELECT 1 FROM health_plan_contracts WHERE health_plan_id = {$healthPlans[$key]->id}");
            $healthPlans[$key]->isNotDeletable = isset($haveData1[0]) || isset($haveData2[0]); 
        }

        return response()->json(['success' => true, 'message' => "", "dados" => $healthPlans], 200);
    }

    public function show(string $id)
    {
        $healthPlan = HealthPlan::find($id);
        return response()->json(['success' => true, 'message' => "", "dados" => $healthPlan], !empty($healthPlan) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $healthPlan = new HealthPlan();
            $healthPlan->description = $request->description;
            $healthPlan->detailed_description = $request->detailed_description;
            $healthPlan->value = $request->value;
            $healthPlan->minimal_animals = $request->minimal_animals;
            $healthPlan->maximum_animals = $request->maximum_animals;
            $healthPlan->plan_colors = $request->plan_colors;
            if ($healthPlan->save()) {
                return response()->json(['success' => true, 'message' => "Plano de saúde cadastrado!", 'dados' => $healthPlan], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $healthPlan = HealthPlan::find($request->id);
            $healthPlan->update($dados);
            return response()->json(['success' => true, 'message' => 'Plano de saúde atualizado!'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $healthPlan = HealthPlan::find($request->id);
            $healthPlan->delete();
            return response()->json(['success' => true, 'message' => "Plano de saúde excluído!"], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getBestsPlansByUser(int $id)
    {
        $servicesController = new HealthPlanServiceController();
        $sql = SqlGetter::getSql('get_bests_plans_by_user');
        $healthPlans = DB::select($sql, [$id, $id]);

        foreach ($healthPlans as $key => $value) {
            $services = $servicesController->getByHealthPlan($value->id)->getData()->dados;
            $healthPlans[$key]->services = $services;
        }

        echo json_encode(['success' => true, 'message' => "", "dados" => $healthPlans]);
    }

    public function getAllPlansByUser(int $id)
    {
        $servicesController = new HealthPlanServiceController();
        $sql = SqlGetter::getSql('get_all_plans_by_user');
        $healthPlans = DB::select($sql, [$id, $id]);

        foreach ($healthPlans as $key => $value) {
            $services = $servicesController->getByHealthPlan($value->id)->getData()->dados;
            $healthPlans[$key]->services = $services;
        }

        echo json_encode(['success' => true, 'message' => "", "dados" => $healthPlans]);
    }

    public function getAnimalsToAddByUser(int $user_id, int $plan_id)
    {
        $sql = SqlGetter::getSql('get_animals_to_add_by_plan_and_user');
        $res = DB::SELECT($sql, [$plan_id, $user_id]);
        return response()->json(['success' => true, 'message' => "", "dados" => $res], 200);
    }
}
