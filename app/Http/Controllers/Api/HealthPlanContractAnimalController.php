<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthPlanContractAnimal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HealthPlanContractAnimalController extends Controller
{
    public function list()
    {
        $healthPlanContractAnimals = DB::table('health_plan_contract_animals')
            ->leftJoin('health_plan_contracts', 'health_plan_contract_animals.contract_id', '=', 'health_plan_contracts.id')
            ->leftJoin('animals', 'health_plan_contract_animals.animal_id', '=', 'animals.id')
            ->select('health_plan_contract_animals.*', 'health_plan_contracts.health_plan_id', 'animals.name as animal')
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $healthPlanContractAnimals], 200);
    }

    public function show(string $id)
    {
        $healthPlanContractAnimal = DB::table('health_plan_contract_animals')
            ->leftJoin('health_plan_contracts', 'health_plan_contract_animals.contract_id', '=', 'health_plan_contracts.id')
            ->leftJoin('animals', 'health_plan_contract_animals.animal_id', '=', 'animals.id')
            ->select('health_plan_contract_animals.*', 'health_plan_contracts.health_plan_id', 'animals.name as animal')
            ->where([['health_plan_contract_animals.id', '=', $id]])
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $healthPlanContractAnimal], !empty($healthPlanContractAnimal) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $healthPlanContractAnimal = new HealthPlanContractAnimal();
            $healthPlanContractAnimal->animal_id = $request->animal_id;
            $healthPlanContractAnimal->contract_id = $request->contract_id;
            $healthPlanContractAnimal->save();
            return response()->json(['success' => true, 'message' => '', 'dados' => $healthPlanContractAnimal], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $healthPlanContractAnimal = HealthPlanContractAnimal::find($request->id);
            $healthPlanContractAnimal->update($dados);
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $healthPlanContractAnimal = HealthPlanContractAnimal::find($request->id);
            $healthPlanContractAnimal->delete();
            return response()->json(['success' => true, 'message' => ""], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByContract(int $id)
    {
        $healthPlanContractAnimal = $this->getBy('health_plan_contract_animals', 'contract_id', $id);
        return response()->json(['success' => true, 'message' => "", "dados" => $healthPlanContractAnimal], count($healthPlanContractAnimal) >= 1 ? 200 : 404);
    }

    public function getBy(string $table, string $field, $value)
    {
        $healthPlanContractAnimal = DB::table('health_plan_contract_animals')
            ->leftJoin('health_plan_contracts', 'health_plan_contract_animals.contract_id', '=', 'health_plan_contracts.id')
            ->leftJoin('animals', 'health_plan_contract_animals.animal_id', '=', 'animals.id')
            ->select('health_plan_contract_animals.*', 'health_plan_contracts.health_plan_id', 'animals.name as animal')
            ->where($table . '.' . $field, '=', $value)
            ->get();

        return $healthPlanContractAnimal;
    }
}
