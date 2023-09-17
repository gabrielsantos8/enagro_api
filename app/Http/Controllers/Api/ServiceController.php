<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function list()
    {
        $services = DB::table('services')
            ->join('animal_subtypes', 'animal_subtypes.id', '=', 'services.animal_subtype_id')
            ->select('services.*', 'animal_subtypes.description as animal_subtype')
            ->get();
        return response()->json(['success' => true, 'message' => "", "dados" => $services], 200);
    }


    public function store(Request $request)
    {
        try {
            $service = new Service();
            $service->description = $request->description;
            $service->animal_subtype_id = $request->animal_subtype_id;
            $service->value = $request->value;
            $service->save();
            return response()->json(['success' => true, 'message' => "Serviço cadastrado!", 'dados' => $service], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    public function show(string $id)
    {
        $service = DB::table('services')
            ->join('animal_subtypes', 'animal_subtypes.id', '=', 'services.animal_subtype_id')
            ->select('services.*', 'animal_subtypes.description as animal_subtype')
            ->where('services.id', '=', $id)
            ->get();
        return response()->json(['success' => true, 'message' => "", "dados" => $service], !empty($service) ? 200 : 404);
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $service = Service::find($request->id);
            $service->update($dados);
            return response()->json(['success' => true, 'message' => 'Serviço atualizado!'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $service = Service::find($request->id);
            $service->delete();
            return response()->json(['success' => true, 'message' => "Serviço excluído!"], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByAnimalSubtype(int $id)
    {
        $service = $this->getBy('animal_subtype_id', $id);
        return response()->json(['success' => true, 'message' => "", "dados" => $service], count($service) >= 1 ? 200 : 404);
    }

    public function getBy(string $field, $value)
    {
        $service = DB::table('services')
            ->join('animal_subtypes', 'animal_subtypes.id', '=', 'services.animal_subtype_id')
            ->select('services.*', 'animal_subtypes.description as animal_subtype')
            ->where('services.' . $field, '=', $value)
            ->get();
        return $service;
    }
}
