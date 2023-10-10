<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthPlanContractAnimal;
use App\Utils\SqlGetter;
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
            ->leftJoin('animal_types', 'animals.animal_type_id', '=', 'animal_types.id')
            ->leftJoin('animal_subtypes', 'animals.animal_subtype_id', '=', 'animal_subtypes.id')
            ->leftJoin('user_addresses', 'animals.user_address_id', '=', 'user_addresses.id')
            ->leftJoin('cities', 'user_addresses.city_id', '=', 'cities.id')
            ->select('health_plan_contract_animals.id as health_plan_contract_animals_id', 'health_plan_contracts.health_plan_id', 'animals.*', 'animal_types.description as animal_type', 'user_addresses.complement', 'cities.id as city_id', 'cities.description as city', 'cities.uf', 'cities.ibge', 'animal_subtypes.description as animal_subtype')
            ->where($table . '.' . $field, '=', $value)
            ->get();

        return $healthPlanContractAnimal;
    }

    public function getAnimalsToAddByUser(int $user_id, int $contract_id)
    {
        $sql = SqlGetter::getSql('get_animals_to_add_by_user');
        $res = DB::SELECT($sql, [$contract_id, $contract_id, $user_id]);
        return response()->json(['success' => true, 'message' => "", "dados" => $res], 200);
    }
}
