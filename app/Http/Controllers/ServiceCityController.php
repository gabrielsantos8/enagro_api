<?php

namespace App\Http\Controllers;

use App\Models\ServiceCity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceCityController extends Controller
{
    public function list()
    {
        $serviceCity = DB::table('service_cities')
            ->join('cities', 'service_cities.city_id', '=', 'cities.id')
            ->join('veterinarians', 'service_cities.veterinarian_id', '=', 'veterinarians.id')
            ->select('service_cities.*', 'cities.description as city', 'cities.uf', 'veterinarians.nome as veterinarian')
            ->get();
        return response()->json(['success' => true, 'message' => "", "dados" => $serviceCity], 200);
    }

    public function show(string $id)
    {
        $serviceCity = DB::table('service_cities')
            ->join('cities', 'service_cities.city_id', '=', 'cities.id')
            ->join('veterinarians', 'service_cities.veterinarian_id', '=', 'veterinarians.id')
            ->select('service_cities.*', 'cities.description as city', 'cities.uf', 'veterinarians.nome as veterinarian')
            ->where('service_cities.id', '=', $id)
            ->get();
        return response()->json(['success' => true, 'message' => "", "dados" => $serviceCity], !empty($serviceCity) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $serviceCity = new ServiceCity();
            $serviceCity->veterinarian_id = $request->veterinarian_id;
            $serviceCity->city_id = $request->city_id;
            if ($serviceCity->save()) {
                return response()->json(['success' => true, 'message' => "Cidade de atendimento cadastrada!", 'dados' => $serviceCity], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $serviceCity = ServiceCity::find($request->id);
            $serviceCity->update($dados);
            return response()->json(['success' => true, 'message' => 'Cidade de atendimento atualizada!'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $serviceCity = ServiceCity::find($request->id);
            $serviceCity->delete();
            return response()->json(['success' => true, 'message' => "Cidade de atendimento excluída!"], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByVeterinarian(int $id)
    {
        $serviceCities = $this->getBy('veterinarian_id', $id);
        return response()->json(['success' => true, 'message' => "", "dados" => $serviceCities], count($serviceCities) >= 1 ? 200 : 404);
    }

    public function getBy(string $field, $value)
    {
        $serviceCity =  DB::table('service_cities')
            ->join('cities', 'service_cities.city_id', '=', 'cities.id')
            ->join('veterinarians', 'service_cities.veterinarian_id', '=', 'veterinarians.id')
            ->select('service_cities.*', 'cities.description as city', 'cities.uf', 'veterinarians.nome as veterinarian')
            ->where('service_cities.' . $field, '=', $value)
            ->get();
        return $serviceCity;
    }
}