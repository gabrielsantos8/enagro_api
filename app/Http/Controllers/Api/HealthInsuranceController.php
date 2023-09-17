<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthInsurance;
use Exception;
use Illuminate\Http\Request;

class HealthInsuranceController extends Controller
{
    public function list()
    {
        $healthInsurances = HealthInsurance::all();
        return response()->json(['success' => true, 'message' => "", "dados" => $healthInsurances], 200);
    }

    public function show(string $id)
    {
        $healthInsurance = HealthInsurance::find($id);
        return response()->json(['success' => true, 'message' => "", "dados" => $healthInsurance], !empty($healthInsurance) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $healthInsurance = new HealthInsurance();
            $healthInsurance->description = $request->description;
            $healthInsurance->detailed_description = $request->detailed_description;
            $healthInsurance->value = $request->value;
            $healthInsurance->minimal_animals = $request->minimal_animals;
            $healthInsurance->maximum_animals = $request->maximum_animals;
            if ($healthInsurance->save()) {
                return response()->json(['success' => true, 'message' => "Plano de saúde cadastrado!", 'dados' => $healthInsurance], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $healthInsurance = HealthInsurance::find($request->id);
            $healthInsurance->update($dados);
            return response()->json(['success' => true, 'message' => 'Plano de saúde atualizado!'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $healthInsurance = HealthInsurance::find($request->id);
            $healthInsurance->delete();
            return response()->json(['success' => true, 'message' => "Plano de saúde excluído!"], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
