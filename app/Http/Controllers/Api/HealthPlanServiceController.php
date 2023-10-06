<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthPlanService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HealthPlanServiceController extends Controller
{
    public function list()
    {
        $healthPlanServices = DB::table('health_plan_services')
            ->leftJoin('health_plans', 'health_plan_services.health_plan_id', '=', 'health_plans.id')
            ->leftJoin('services', 'health_plan_services.service_id', '=', 'services.id')
            ->leftJoin('animal_subtypes', 'services.animal_subtype_id', '=', 'animal_subtypes.id')
            ->leftJoin('animal_types', 'animal_subtypes.animal_type_id', '=', 'animal_types.id')
            ->select(
                'health_plan_services.*',
                'health_plans.description as health_plans',
                'services.*',
                'animal_subtypes.description as animal_subtype',
                'animal_subtypes.animal_type_id',
                'animal_types.description as animal_type'
            )
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $healthPlanServices], 200);
    }

    public function show(string $id)
    {
        $healthPlanService = DB::table('health_plan_services')
            ->leftJoin('health_plans', 'health_plan_services.health_plan_id', '=', 'health_plans.id')
            ->leftJoin('services', 'health_plan_services.service_id', '=', 'services.id')
            ->leftJoin('animal_subtypes', 'services.animal_subtype_id', '=', 'animal_subtypes.id')
            ->leftJoin('animal_types', 'animal_subtypes.animal_type_id', '=', 'animal_types.id')
            ->select(
                'health_plan_services.*',
                'health_plans.description as health_plans',
                'services.*',
                'animal_subtypes.description as animal_subtype',
                'animal_subtypes.animal_type_id',
                'animal_types.description as animal_type'
            )
            ->where([['health_plan_services.id', '=', $id]])
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $healthPlanService], !empty($healthPlanService) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $healthPlanService = new HealthPlanService();
            $healthPlanService->service_id = $request->service_id;
            $healthPlanService->health_plan_id = $request->health_plan_id;
            $healthPlanService->save();
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $healthPlanService = HealthPlanService::find($request->id);
            $healthPlanService->update($dados);
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $healthPlanService = HealthPlanService::find($request->id);
            $healthPlanService->delete();
            return response()->json(['success' => true, 'message' => ""], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByHealthPlan(int $id)
    {
        $healthPlanService = $this->getBy([['health_plan_services.health_plan_id', '=', $id]]);
        return response()->json(['success' => true, 'message' => "", "dados" => $healthPlanService], 200);
    }

    public function getBy(array $wheres)
    {
        $healthPlanService = DB::table('health_plan_services')
            ->leftJoin('health_plans', 'health_plan_services.health_plan_id', '=', 'health_plans.id')
            ->leftJoin('services', 'health_plan_services.service_id', '=', 'services.id')
            ->leftJoin('animal_subtypes', 'services.animal_subtype_id', '=', 'animal_subtypes.id')
            ->leftJoin('animal_types', 'animal_subtypes.animal_type_id', '=', 'animal_types.id')
            ->select(
                'health_plan_services.*',
                'health_plans.description as health_plans',
                'services.*',
                'animal_subtypes.description as animal_subtype',
                'animal_subtypes.animal_type_id',
                'animal_types.description as animal_type'
            )
            ->where($wheres)
            ->get();

        return $healthPlanService;
    }
}
