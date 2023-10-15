<?php

namespace App\Services;

use App\Models\HealthPlanContract;
use App\Models\HealthPlanContractAnimal;
use App\Models\HealthPlanContractInstallment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Utils\SqlGetter;
use Illuminate\Support\Facades\DB;

class SignatureService
{

    public function startSign(Request $req)
    {
        if($this->contractExists($req->user_id)) {
            $this->cancelContractInstallment($req->user_id);
            $this->cancelContract($req->user_id);
        }
        $contract = $this->insContract($req);
        $installment = $this->insInstallment($contract);
        $animals = array();
        if($req->animals != '') {
            $animals = $this->insAnimals($contract, $req->animals);
        }
        return ['contract' => $contract, 'installment' => $installment, 'animals' => $animals];
    }

    private function contractExists(int $user_id) {
        $ret = DB::select(SqlGetter::getSql('exists_contract_by_user'), [$user_id]);
        return isset($ret[0]);
    }

    private function cancelContractInstallment(int $user_id) {
        $ret = DB::select(SqlGetter::getSql('cancel_contract_installment_by_user'), [$user_id]);
        return isset($ret[0]);
    }

    private function cancelContract(int $user_id) {
        $ret = DB::select(SqlGetter::getSql('cancel_contract_by_user'), [$user_id]);
        return isset($ret[0]);
    }

    private function insContract(Request $req)
    {
        $healthPlanContract = new HealthPlanContract();
        $healthPlanContract->health_plan_id = $req->health_plan_id;
        $healthPlanContract->user_id = $req->user_id;
        $healthPlanContract->health_plan_contract_type_id = $req->health_plan_contract_type_id;
        $healthPlanContract->health_plan_contract_status_id = 1;
        $healthPlanContract->value = $req->value;
        $healthPlanContract->save();
        return $healthPlanContract;
    }

    private function insInstallment(HealthPlanContract $contract)
    {
        $healthPlanContractsInstallment = new HealthPlanContractInstallment();
        $healthPlanContractsInstallment->status_id = 2;
        $healthPlanContractsInstallment->contract_id = $contract->id;
        $healthPlanContractsInstallment->installment_number = 1;
        $healthPlanContractsInstallment->due_date = $this->getDueDate($contract->health_plan_contract_type_id);
        $healthPlanContractsInstallment->value = $contract->value;
        $healthPlanContractsInstallment->save();
        return $healthPlanContractsInstallment;
    }

    private function getDueDate(int $typeId)
    {
        $currentDate = Carbon::now();
        if ($typeId === 1) {
            return $currentDate->addDays(30);
        } elseif ($typeId === 2) {
            return $currentDate->addYear();
        }
        return $currentDate;
    }

    private function insAnimals(HealthPlanContract $contract, string $animals)
    {
        $arrayAnimals = array();
        $animalsToIns = explode(',', $animals);
        foreach ($animalsToIns as $key => $value) {
            $healthPlanContractAnimal = new HealthPlanContractAnimal();
            $healthPlanContractAnimal->animal_id = intval($value);
            $healthPlanContractAnimal->contract_id = $contract->id;
            $healthPlanContractAnimal->save();
            $arrayAnimals[] = $healthPlanContractAnimal;
        }
        return $arrayAnimals;
    }
}
