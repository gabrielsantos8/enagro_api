<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function list()
    {
        $cities = City::all();
        return response()->json(['success' => true, 'message' => "", "dados" => $cities], 200);
    }

    public function store(Request $request)
    {
        try {
            $city = new City();
            $city->description = $request->description;
            $city->uf = $request->uf;
            $city->ibge = $request->ibge;
            if ($city->save()) {
                return response()->json(['success' => true, 'message' => "Cidade cadastrada!", 'dados' => $city], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        $city = City::find($id);
        return response()->json(['success' => true, 'message' => !empty($city) ? "" : "Cidade não encontrada!", "dados" => $city], !empty($city) ? 200 : 404);
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $city = City::find($request->id);
            $city->update($dados);
            return response()->json(['success' => true, 'message' => 'Cidade atualizada!'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $city = City::find($request->id);
            $city->delete();
            return response()->json(['success' => true, 'message' => "Cidade excluída!"], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getUfs()
    {
        $ufs = DB::table('cities')->select('uf')->groupBy('uf')->get();
        return response()->json(['success' => true, 'message' => '', 'dados' => $ufs], 200);
    }

    public function getCities(string $uf)
    {
        $cities = DB::table('cities')->select(['cities.id', 'cities.description'])->where('uf', '=', $uf)->get();
        $cities[] = ['id' => 0, 'description' => 'Selecione'];
        return response()->json(['success' => true, 'message' => '', 'dados' =>  $cities], 200);
    }
}
