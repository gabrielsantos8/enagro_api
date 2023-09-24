<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivationAnimal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivationAnimalController extends Controller
{
    public function list()
    {
        $activationAnimals = DB::table('activation_animals')
            ->leftJoin('activations', 'activation_animals.activation_id', '=', 'activations.id')
            ->leftJoin('animals', 'activation_animals.animal_id', '=', 'animals.id')
            ->select('activation_animals.*', 'animals.name as animal')
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $activationAnimals], 200);
    }

    public function show(string $id)
    {
        $activationAnimal = DB::table('activation_animals')
            ->leftJoin('activations', 'activation_animals.activation_id', '=', 'activations.id')
            ->leftJoin('animals', 'activation_animals.animal_id', '=', 'animals.id')
            ->select('activation_animals.*', 'animals.name as animal')
            ->where([['activation_animals.id', '=', $id]])
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $activationAnimal], !empty($activationAnimal) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $activationAnimal = new ActivationAnimal();
            $activationAnimal->animal_id = $request->animal_id;
            $activationAnimal->activation_id = $request->activation_id;
            $activationAnimal->save();
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $activationAnimal = ActivationAnimal::find($request->id);
            $activationAnimal->update($dados);
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $activationAnimal = ActivationAnimal::find($request->id);
            if (isset($activationAnimal)) {
                $activationAnimal->delete();
            }
            return response()->json(['success' => true, 'message' => ""], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByActivation(int $id)
    {
        $activationAnimal = $this->getBy('activation_animals', 'activation_id', $id);
        return response()->json(['success' => true, 'message' => "", "dados" => $activationAnimal], count($activationAnimal) >= 1 ? 200 : 404);
    }

    public function getBy(string $table, string $field, $value)
    {
        $activationAnimal =  DB::table('activation_animals')
        ->leftJoin('activations', 'activation_animals.activation_id', '=', 'activations.id')
        ->leftJoin('animals', 'activation_animals.animal_id', '=', 'animals.id')
        ->select('activation_animals.*', 'animals.name as animal')
        ->where([[$table.'.'.$field, '=', $value]])
        ->get();

        return $activationAnimal;
    }
}
