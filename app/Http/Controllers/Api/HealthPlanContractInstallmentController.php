<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthPlanContractInstallment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HealthPlanContractInstallmentController extends Controller
{
    public function list()
    {
        $healthPlanContractsInstallments = DB::table('health_plan_contracts_installments')
            ->leftJoin('health_plan_contracts', 'health_plan_contracts_installments.contract_id', '=', 'health_plan_contracts.id')
            ->leftJoin('health_plan_contracts_installments_status', 'health_plan_contracts_installments.status_id', '=', 'health_plan_contracts_installments_status.id')
            ->select('health_plan_contracts_installments.*', 'health_plan_contracts.health_plan_id', 'health_plan_contracts_installments_status.description as health_plan_contracts_installments_status')
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $healthPlanContractsInstallments], 200);
    }

    public function show(string $id)
    {
        $healthPlanContractsInstallment = DB::table('health_plan_contracts_installments')
            ->leftJoin('health_plan_contracts', 'health_plan_contracts_installments.contract_id', '=', 'health_plan_contracts.id')
            ->leftJoin('health_plan_contracts_installments_status', 'health_plan_contracts_installments.status_id', '=', 'health_plan_contracts_installments_status.id')
            ->select('health_plan_contracts_installments.*', 'health_plan_contracts.health_plan_id', 'health_plan_contracts_installments_status.description as health_plan_contracts_installments_status')
            ->where([['health_plan_contracts_installments.id', '=', $id]])
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $healthPlanContractsInstallment], !empty($healthPlanContractsInstallment) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $healthPlanContractsInstallment = new HealthPlanContractInstallment();
            $healthPlanContractsInstallment->status_id = $request->status_id;
            $healthPlanContractsInstallment->contract_id = $request->contract_id;
            $healthPlanContractsInstallment->installment_number = $request->installment_number;
            $healthPlanContractsInstallment->due_date = $request->due_date;
            $healthPlanContractsInstallment->value = $request->value;
            $healthPlanContractsInstallment->save();
            return response()->json(['success' => true, 'message' => '', 'dados' => $healthPlanContractsInstallment], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $healthPlanContractsInstallment = HealthPlanContractInstallment::find($request->id);
            $healthPlanContractsInstallment->update($dados);
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $healthPlanContractsInstallment = HealthPlanContractInstallment::find($request->id);
            $healthPlanContractsInstallment->delete();
            return response()->json(['success' => true, 'message' => ""], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByContract(int $id)
    {
        $healthPlanContractsInstallment = $this->getBy('health_plan_contracts_installments', 'contract_id', $id);
        return response()->json(['success' => true, 'message' => "", "dados" => $healthPlanContractsInstallment], count($healthPlanContractsInstallment) >= 1 ? 200 : 404);
    }

    public function getBy(string $table, string $field, $value)
    {
        $healthPlanContractsInstallment = DB::table('health_plan_contracts_installments')
            ->leftJoin('health_plan_contracts', 'health_plan_contracts_installments.contract_id', '=', 'health_plan_contracts.id')
            ->leftJoin('health_plan_contracts_installments_status', 'health_plan_contracts_installments.status_id', '=', 'health_plan_contracts_installments_status.id')
            ->select('health_plan_contracts_installments.*', 'health_plan_contracts.health_plan_id', 'health_plan_contracts_installments_status.description as health_plan_contracts_installments_status')
            ->where($table . '.' . $field, '=', $value)
            ->get();

        return $healthPlanContractsInstallment;
    }
}
