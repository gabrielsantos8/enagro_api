<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivationServiceController extends Controller
{
    public function list()
    {
        $activationServices = DB::table('activation_services')
            ->leftJoin('activations', 'activation_services.activation_id', '=', 'activations.id')
            ->leftJoin('services', 'activation_services.service_id', '=', 'services.id')
            ->select('activation_services.*', 'services.description as service')
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $activationServices], 200);
    }

    public function show(string $id)
    {
        $activationService = DB::table('activation_services')
            ->leftJoin('activations', 'activation_services.activation_id', '=', 'activations.id')
            ->leftJoin('services', 'activation_services.service_id', '=', 'services.id')
            ->select('activation_services.*', 'services.description as service')
            ->where([['activation_services.id', '=', $id]])
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $activationService], !empty($activationService) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $activationService = new ActivationService();
            $activationService->service_id = $request->service_id;
            $activationService->activation_id = $request->activation_id;
            $activationService->value  = $request->value;
            $activationService->save();
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $activationService = ActivationService::find($request->id);
            $activationService->update($dados);
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $activationService = ActivationService::find($request->id);
            if (isset($activationService)) {
                $activationService->delete();
            }
            return response()->json(['success' => true, 'message' => ""], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByActivation(int $id)
    {
        $activationService = $this->getBy('activation_services', 'activation_id', $id);
        return response()->json(['success' => true, 'message' => "", "dados" => $activationService], count($activationService) >= 1 ? 200 : 404);
    }

    public function getBy(string $table, string $field, $value)
    {
        $activationService =  DB::table('activation_services')
        ->leftJoin('activations', 'activation_services.activation_id', '=', 'activations.id')
        ->leftJoin('services', 'activation_services.service_id', '=', 'services.id')
        ->select('activation_services.*', 'services.description as service')
        ->where([[$table.'.'.$field, '=', $value]])
        ->get();

        return $activationService;
    }
}
