<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VeterinarianService;
use App\Utils\SqlGetter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VeterinarianServiceController extends Controller
{
    public function list()
    {
        $veterinarianServices = DB::table('veterinarian_services')
            ->leftJoin('veterinarians', 'veterinarian_services.veterinarian_id', '=', 'veterinarians.id')
            ->leftJoin('services', 'veterinarian_services.service_id', '=', 'services.id')
            ->select('veterinarian_services.*', 'veterinarians.nome as veterinarian', 'services.description as service')
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $veterinarianServices], 200);
    }

    public function show(string $id)
    {
        $veterinarianService = DB::table('veterinarian_services')
            ->leftJoin('veterinarians', 'veterinarian_services.veterinarian_id', '=', 'veterinarians.id')
            ->leftJoin('services', 'veterinarian_services.service_id', '=', 'services.id')
            ->select('veterinarian_services.*', 'veterinarians.nome as veterinarian', 'services.description as service')
            ->where([['veterinarian_services.id', '=', $id]])
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $veterinarianService], !empty($veterinarianService) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $veterinarianService = new VeterinarianService();
            $veterinarianService->service_id = $request->service_id;
            $veterinarianService->veterinarian_id = $request->veterinarian_id;
            $veterinarianService->save();
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $veterinarianService = VeterinarianService::find($request->id);
            $veterinarianService->update($dados);
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $veterinarianService = VeterinarianService::find($request->id);
            if (isset($veterinarianService)) {
                $veterinarianService->delete();
            }
            return response()->json(['success' => true, 'message' => ""], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByVeterinarian(int $veterinarian_id)
    {
        $services = DB::select(SqlGetter::getSql('get_services_by_veterinarian'),[$veterinarian_id]);
        return response()->json(['success' => true, 'message' => "", "dados" => $services], 200);
    }

    public function getNotByVeterinarian(int $veterinarian_id)
    {
        $services = DB::select(SqlGetter::getSql('get_services_notby_veterinarian'),[$veterinarian_id]);
        return response()->json(['success' => true, 'message' => "", "dados" => $services], 200);
    }

    public function getBy(string $table, string $field, $value)
    {
        $veterinarianService =  DB::table('veterinarian_services')
        ->leftJoin('veterinarians', 'veterinarian_services.veterinarian_id', '=', 'veterinarians.id')
        ->leftJoin('services', 'veterinarian_services.service_id', '=', 'services.id')
        ->select('veterinarian_services.*', 'veterinarians.nome as veterinarian', 'services.description as service')
        ->where([[$table.'.'.$field, '=', $value]])
        ->get();

        return $veterinarianService;
    }
}
