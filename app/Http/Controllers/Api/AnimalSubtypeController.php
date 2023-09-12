<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AnimalSubtype;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnimalSubtypeController extends Controller
{
    public function list()
    {
        $animal_subtypes = DB::table('animal_subtypes')
            ->leftJoin('animal_types', 'animal_subtypes.animal_type_id', '=', 'animal_types.id')
            ->select('animal_subtypes.*', 'animal_types.description as animal_type')
            ->get();
        return response()->json(['success' => true, 'message' => "", "dados" => $animal_subtypes], 200);
    }

    public function store(Request $request)
    {
        try {
            $animal_subtype = new AnimalSubtype();
            $animal_subtype->description = $request->description;
            $animal_subtype->animal_type_id = $request->animal_type_id;
            if ($animal_subtype->save()) {
                return response()->json(['success' => true, 'message' => "Subtipo de animal cadastrado!", 'dados' => $animal_subtype], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        $animal_subtype = DB::table('animal_subtypes')
            ->leftJoin('animal_types', 'animal_subtypes.animal_type_id', '=', 'animal_types.id')
            ->select('animal_subtypes.*', 'animal_types.description as animal_type')
            ->where([['animal_subtypes.id', '=', $id]])
            ->get();
        return response()->json(['success' => true, 'message' => !empty($animal_subtype) ? "" : "Subtipo de animal não encontrado!", "dados" => $animal_subtype], !empty($animal_subtype) ? 200 : 404);
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $animal_subtype = AnimalSubtype::find($request->id);
            $animal_subtype->update($dados);
            return response()->json(['success' => true, 'message' => 'Subtipo de animal atualizado!'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $animal_subtype = AnimalSubtype::find($request->id);
            $animal_subtype->delete();
            return response()->json(['success' => true, 'message' => "Subtipo de animal excluído!"], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByAnimalType(int $id)
    {
        $animal_subtypes = DB::table('animal_subtypes')
            ->leftJoin('animal_types', 'animal_subtypes.animal_type_id', '=', 'animal_types.id')
            ->select('animal_subtypes.*', 'animal_types.description as animal_type')
            ->where([['animal_types.id', '=', $id]])
            ->get();
        return response()->json(['success' => true, 'message' => "", "dados" => $animal_subtypes], 200); 
    }
}
