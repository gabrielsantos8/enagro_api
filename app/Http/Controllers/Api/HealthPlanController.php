<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthPlan;
use Exception;
use Illuminate\Http\Request;

class HealthPlanController extends Controller
{
    public function list()
    {
        $healthPlans = HealthPlan::all();
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
}
