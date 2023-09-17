<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthInsuranceService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HealthInsuranceServiceController extends Controller
{
    public function list()
    {
        $healthInsuranceServices = DB::table('health_insurance_services')
            ->leftJoin('health_insurances', 'health_insurance_services.health_insurance_id', '=', 'health_insurances.id')
            ->leftJoin('services', 'health_insurance_services.service_id', '=', 'services.id')
            ->select('health_insurance_services.*', 'health_insurances.description as health_insurances', 'services.description as service')
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $healthInsuranceServices], 200);
    }

    public function show(string $id)
    {
        $healthInsuranceService = DB::table('health_insurance_services')
            ->leftJoin('health_insurances', 'health_insurance_services.health_insurance_id', '=', 'health_insurances.id')
            ->leftJoin('services', 'health_insurance_services.service_id', '=', 'services.id')
            ->select('health_insurance_services.*', 'health_insurances.description as health_insurances', 'services.description as service')
            ->where([['health_insurance_services.id', '=', $id]])
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $healthInsuranceService], !empty($healthInsuranceService) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $healthInsuranceService = new HealthInsuranceService();
            $healthInsuranceService->service_id = $request->service_id;
            $healthInsuranceService->health_insurance_id = $request->health_insurance_id;
            $healthInsuranceService->save();
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $healthInsuranceService = HealthInsuranceService::find($request->id);
            $healthInsuranceService->update($dados);
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $healthInsuranceService = HealthInsuranceService::find($request->id);
            $healthInsuranceService->delete();
            return response()->json(['success' => true, 'message' => ""], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
