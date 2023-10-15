<?php

namespace App\Services;

use App\Models\HealthPlanContractInstallment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentService
{

    public function installmentPayment(Request $req)
    {
        $installment = HealthPlanContractInstallment::find($req->installment_id);
        if (!$installment) {
            return response()->json(['success' => false, 'message' => "Nenhum parcela encontrada"], 200);
        }
        $installment->update(['status_id' => 1]);
        $nextInstallment = $this->insNextInstallment($installment, $req->type_id);
        return ['installment_pay' => $installment, 'next_installment' => $nextInstallment];
    }

    private function insNextInstallment(HealthPlanContractInstallment $ins, int $typeId)
    {
        $currentDate = Carbon::createFromFormat('Y-m-d H:i:s', $ins->due_date . ' 08:08:08');
        $dueDate = null;
        if ($typeId === 1) {
            $dueDate = $currentDate->addDays(30);
        } elseif ($typeId === 2) {
            $dueDate = $currentDate->addYear();
        }
        $nextIns = new HealthPlanContractInstallment();
        $nextIns->contract_id = $ins->contract_id;
        $nextIns->installment_number = $ins->installment_number + 1;
        $nextIns->due_date = $dueDate->format('Y-m-d');
        $nextIns->value = $ins->value;
        $nextIns->status_id = 2;
        $nextIns->save();
        return $nextIns;
    }
}
