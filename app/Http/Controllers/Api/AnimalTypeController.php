<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AnimalType;
use Exception;
use Illuminate\Http\Request;

class AnimalTypeController extends Controller
{
    public function list()
    {
        $animal_types = AnimalType::all();
        return response()->json(['success' => true, 'message' => "", "dados" => $animal_types], 200);
    }

    public function store(Request $request)
    {
        try {
            $animal_type = new AnimalType();
            $animal_type->description = $request->description;
            if ($animal_type->save()) {
                return response()->json(['success' => true, 'message' => "Tipo de animal cadastrado!", 'dados' => $animal_type], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        $animal_type = AnimalType::find($id);
        return response()->json(['success' => true, 'message' => !empty($animal_type) ? "" : "Tipo de animal não encontrado!", "dados" => $animal_type], !empty($animal_type) ? 200 : 404);
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $animal_type = AnimalType::find($request->id);
            $animal_type->update($dados);
            return response()->json(['success' => true, 'message' => 'Tipo de animal atualizado!'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $animal_type = AnimalType::find($request->id);
            $animal_type->delete();
            return response()->json(['success' => true, 'message' => "Tipo de animal excluído!"], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
