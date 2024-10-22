<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\AnimalSubtype;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnimalController extends Controller
{
    public function list()
    {
        $animal = DB::table('animals')
            ->join('animal_types', 'animals.animal_type_id', '=', 'animal_types.id')
            ->join('animal_subtypes', 'animals.animal_subtype_id', '=', 'animal_subtypes.id')
            ->join('user_addresses', 'animals.user_address_id', '=', 'user_addresses.id')
            ->join('cities', 'user_addresses.city_id', '=', 'cities.id')
            ->select('animals.*', 'animal_types.description as animal_type', 'user_addresses.complement', 'cities.id as city_id', 'cities.description as city', 'cities.uf', 'cities.ibge', 'animal_subtypes.description as animal_subtype')
            ->get();
        foreach ($animal as $key => $value) {
            $haveData = DB::select("SELECT 1 FROM activation_animals WHERE animal_id = {$animal[$key]->id}");
            $haveData2 = DB::select("SELECT 1 FROM health_plan_contract_animals WHERE animal_id = {$animal[$key]->id}");
            $animal[$key]->isNotDeletable = isset($haveData[0])|| isset($haveData2[0]);
        }
        return response()->json(['success' => true, 'message' => "", "dados" => $animal], 200);
    }

    public function show(string $id)
    {
        $animal = DB::table('animals')
            ->join('animal_types', 'animals.animal_type_id', '=', 'animal_types.id')
            ->join('animal_subtypes', 'animals.animal_subtype_id', '=', 'animal_subtypes.id')
            ->join('user_addresses', 'animals.user_address_id', '=', 'user_addresses.id')
            ->join('cities', 'user_addresses.city_id', '=', 'cities.id')
            ->select('animals.*', 'animal_types.description as animal_type', 'user_addresses.complement', 'cities.id as city_id', 'cities.description as city', 'cities.uf', 'cities.ibge', 'animal_subtypes.description as animal_subtype')
            ->where('animals.id', '=', $id)
            ->get();
        return response()->json(['success' => true, 'message' => "", "dados" => $animal], !empty($animal) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $stype  = AnimalSubtype::find($request->animal_subtype_id);
            $type = !isset($request->animal_type_id) ? $stype->animal_type_id : $request->animal_type_id;
            $animal = new Animal();
            $animal->name = $request->name;
            $animal->description = $request->description;
            $animal->animal_type_id =  $type;
            $animal->img_url = $request->img_url;
            $animal->user_address_id = $request->user_address_id;
            $animal->birth_date = $request->birth_date;
            $animal->animal_subtype_id = $request->animal_subtype_id;
            $animal->weight = $request->weight;
            $animal->amount = in_array($request->animal_subtype_id, [3,4]) ? $request->amount : 1;
            if ($animal->save()) {
                return response()->json(['success' => true, 'message' => "Animal cadastrado!", 'dados' => $animal], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $animal = Animal::find($request->id);
            $animal->update($dados);
            return response()->json(['success' => true, 'message' => 'Animal atualizado!'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $animal = Animal::find($request->id);
            $animal->delete();
            return response()->json(['success' => true, 'message' => "Animal excluído!"], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByUser(int $id)
    {
        $animal = $this->getBy('user_addresses', 'user_id', $id);
        return response()->json(['success' => true, 'message' => "", "dados" => $animal], count($animal) >= 1 ? 200 : 404);
    }

    public function getBy(string $table, string $field, $value)
    {
        $animal = DB::table('animals')
            ->join('animal_types', 'animals.animal_type_id', '=', 'animal_types.id')
            ->join('animal_subtypes', 'animals.animal_subtype_id', '=', 'animal_subtypes.id')
            ->join('user_addresses', 'animals.user_address_id', '=', 'user_addresses.id')
            ->join('cities', 'user_addresses.city_id', '=', 'cities.id')
            ->select('animals.*', 'animal_types.description as animal_type', 'user_addresses.complement', 'cities.id as city_id', 'cities.description as city', 'cities.uf', 'cities.ibge', 'animal_subtypes.description as animal_subtype')
            ->where($table . '.' . $field, '=', $value)
            ->orderBy('user_addresses.id')
            ->orderBy('animals.name')
            ->get();
        
        foreach ($animal as $key => $value) {
            $haveData = DB::select("SELECT 1 FROM activation_animals WHERE animal_id = {$animal[$key]->id}");
            $haveData2 = DB::select("SELECT 1 FROM health_plan_contract_animals WHERE animal_id = {$animal[$key]->id}");
            $animal[$key]->is_not_deletable = isset($haveData[0])|| isset($haveData2[0]);
        }

        return $animal;
    }

    public function getImage(int $id)
    {
        try {
            $animal = Animal::find($id);
            if (!empty($animal->img_url)) {
                return response()->json(['success' => true, 'message' => "", 'img_url' => $animal->img_url], 200);
            }
            return response()->json(['success' => false, 'message' => "Nenhuma imagem encontrada"], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }

    public function removeImage(int $id)
    {
        try {
            $animal = Animal::find($id);
            $animal->update(['img_url' => "https://static.thenounproject.com/png/1554486-200.png"]);
            return response()->json(['success' => true, 'message' => ""], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }

    public function sendImage(Request $request)
    {
        $fileCtrl = new FileUploadController();
        try {
            $fileCtrl->uploadAnimal($request);
            return response()->json(['success' => true, 'message' => ""], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }
}
