<?php

namespace App\Services;

use App\Models\HealthPlanContract;
use App\Models\HealthPlanContractAnimal;
use App\Models\HealthPlanContractInstallment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SignatureService
{

    public function startSign(Request $req)
    {
        $contract = $this->insContract($req);
        $installment = $this->insInstallment($contract);
        $animals = $this->insAnimals($contract, $req->animals);
        return ['contract' => $contract, 'installment' => $installment, 'animals' => $animals];
    }

    private function insContract(Request $req)
    {
        $healthPlanContract = new HealthPlanContract();
        $healthPlanContract->health_plan_id = $req->health_plan_id;
        $healthPlanContract->user_id = $req->user_id;
        $healthPlanContract->health_plan_contract_type_id = $req->health_plan_contract_type_id;
        $healthPlanContract->health_plan_contract_status_id = 1;
        $healthPlanContract->value = $this->calcContractValue($req->health_plan_contract_type_id, $req->value);
        $healthPlanContract->save();
        return $healthPlanContract;
    }

    private function calcContractValue(int $type, float $value)
    {
        return $type == 1 ? $value : $value * 12;
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