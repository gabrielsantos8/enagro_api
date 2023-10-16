<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activation;
use App\Services\ConActivationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivationController extends Controller
{
    public function list()
    {
        $activations = DB::table('activations')
            ->leftJoin('veterinarians', 'activations.veterinarian_id', '=', 'veterinarians.id')
            ->leftJoin('health_plan_contracts', 'activations.contract_id', '=', 'health_plan_contracts.id')
            ->leftJoin('activation_status', 'activations.activation_status_id', '=', 'activation_status.id')
            ->leftJoin('activation_types', 'activations.activation_type_id', '=', 'activation_types.id')
            ->select('activations.*', 'veterinarians.nome as veterinarian', 'activation_types.description as tipo', 'activation_status.description as status')
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $activations], 200);
    }

    public function show(string $id)
    {
        $activation = DB::table('activations')
            ->leftJoin('veterinarians', 'activations.veterinarian_id', '=', 'veterinarians.id')
            ->leftJoin('health_plan_contracts', 'activations.contract_id', '=', 'health_plan_contracts.id')
            ->leftJoin('activation_status', 'activations.activation_status_id', '=', 'activation_status.id')
            ->leftJoin('activation_types', 'activations.activation_type_id', '=', 'activation_types.id')
            ->select('activations.*', 'veterinarians.nome as veterinarian', 'activation_types.description as tipo', 'activation_status.description as status')
            ->where([['activations.id', '=', $id]])
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $activation], !empty($activation) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $activation = new Activation();
            $activation->contract_id = $request->contract_id;
            $activation->veterinarian_id = $request->veterinarian_id;
            $activation->activation_status_id = $request->activation_status_id;
            $activation->activation_type_id = $request->activation_type_id;
            $activation->scheduled_date = $request->scheduled_date;
            $activation->activation_date = $request->activation_date;
            $activation->save();
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $activation = Activation::find($request->id);
            $activation->update($dados);
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $activation = Activation::find($request->id);
            if (isset($activation)) {
                $activation->delete();
            }
            return response()->json(['success' => true, 'message' => ""], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByVeterinarian(int $id)
    {
        $activation = $this->getBy('activations', 'veterinarian_id', $id);
        return response()->json(['success' => true, 'message' => "", "dados" => $activation], count($activation) >= 1 ? 200 : 404);
    }

    public function getByUser(int $id)
    {
        $activation = $this->getBy('health_plan_contracts', 'user_id', $id);
        return response()->json(['success' => true, 'message' => "", "dados" => $activation], count($activation) >= 1 ? 200 : 404);
    }

    public function getBy(string $table, string $field, $value)
    {
        $activation =  DB::table('activations')
            ->leftJoin('veterinarians', 'activations.veterinarian_id', '=', 'veterinarians.id')
            ->leftJoin('health_plan_contracts', 'activations.contract_id', '=', 'health_plan_contracts.id')
            ->leftJoin('activation_status', 'activations.activation_status_id', '=', 'activation_status.id')
            ->leftJoin('activation_types', 'activations.activation_type_id', '=', 'activation_types.id')
            ->select('activations.*', 'veterinarians.nome as veterinarian', 'activation_types.description as tipo', 'activation_status.description as status')
            ->where([[$table . '.' . $field, '=', $value]])
            ->get();

        return $activation;
    }

    public function findBestVeterinarian(Request $req)
    {
        try {
            $service = new ConActivationService();
            $ret  = $service->findBestVeterinarianForService($req);
            return response()->json(['success' => true, 'message' => '', 'dados' => $ret], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function createActivation(Request $req)
    {
        try {
            $service = new ConActivationService();
            $ret  = $service->createActivation($req);
            return response()->json(['success' => true, 'message' => '', 'dados' => $ret], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
