<?php

namespace App\Services;

use App\Models\Activation;
use App\Models\ActivationAnimal;
use App\Models\ActivationService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Utils\SqlGetter;
use Illuminate\Support\Facades\DB;

class ConActivationService
{
    public function findBestVeterinarianForService(Request $req)
    {
        $ret = DB::select(SqlGetter::getSql('get_bests_veterinarians_by_animal'), [$req->animals_id, $req->services_id]);
        return $ret;
    }

    public function createActivation(Request $req)
    {
        $activation = $this->insActivation($req);
        $animals = $this->insAnimals($activation, $req->animals);
        $services = $this->insServices($activation, $req->services);
        return ['activation' => $activation, 'animals' => $animals, 'services' => $services];
    }

    private function insActivation(Request $req)
    {
        $activation = new Activation();
        $activation->contract_id = $req->contract_id;
        $activation->veterinarian_id = $req->veterinarian_id;
        $activation->activation_status_id = 3;
        $activation->activation_type_id = $req->activation_type_id;
        $activation->scheduled_date = $req->scheduled_date;
        $activation->activation_date = Carbon::now()->format('Y-m-d');
        $activation->save();
        return $activation;
    }

    private function insAnimals(Activation $activation, string $animals)
    {
        $arrayAnimals = array();
        $animalsToIns = explode(',', $animals);
        foreach ($animalsToIns as $key => $value) {
            $activationAnimal = new ActivationAnimal();
            $activationAnimal->animal_id = intval($value);
            $activationAnimal->activation_id = $activation->id;
            $activationAnimal->save();
            $arrayAnimals[] = $activationAnimal;
        }
        return $arrayAnimals;
    }

    private function insServices(Activation $activation, string $services)
    {
        $arrayServices = array();
        $servicesToIns = explode(',', $services);
        foreach ($servicesToIns as $key => $value) {
            $realValues = explode(';', $value);
            $activationService = new ActivationService();
            $activationService->service_id = intval($realValues[0]);
            $activationService->value = floatval($realValues[1]);
            $activationService->activation_id = $activation->id;
            $activationService->save();
            $arrayServices[] = $activationService;
        }
        return $arrayServices;
    }
}
