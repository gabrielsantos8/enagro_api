<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\HealthPlanController as ApiHealthPlanController;
use App\Http\Controllers\Api\HealthPlanServiceController;
use App\Models\HealthPlanService;
use App\Utils\SqlGetter;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class HealthPlanController extends Controller
{
    private $apiController;

    public function __construct()
    {
        $this->apiController = new ApiHealthPlanController();
    }


    public function index()
    {
        $apiData = $this->apiController->list()->getData()->dados;
        foreach ($apiData as $item) {
            if ($item->created_at != null) {
                $item->created_at = Carbon::parse($item->created_at)->format('d/m/Y H:i:s');
                $item->updated_at = Carbon::parse($item->updated_at)->format('d/m/Y H:i:s');
            }
        }
        return view('health_plan.index', ['data' => $apiData]);
    }


    public function create($err = "")
    {
        return view('health_plan.create', ["error" => $err]);
    }

    public function store(Request $req)
    {
        $ret = $this->apiController->store($req)->getData();
        if ($ret->success) {
            return redirect('/health_plan');
        }
        return $this->create($ret->message);
    }

    public function edit(int $id, $err = "")
    {
        $data = $this->apiController->show($id)->getData()->dados;
        $data->plan_colors = explode(',', str_replace('ff', '#', $data->plan_colors))[1];
        return view('health_plan.edit', ['data' => $data, 'error' => $err]);
    }


    public function update(Request $req)
    {
        $ret = $this->apiController->update($req)->getData();
        if ($ret->success) {
            return redirect('/health_plan');
        }
        return $this->edit($req->id, $ret->message);
    }

    public function destroy(Request $req)
    {
        $ret = $this->apiController->destroy($req)->getData();
        if ($ret->success) {
            return redirect('/health_plan');
        }
        return $this->index($ret->message);
    }


    public function services(int $id)
    {
        $data = DB::select(SqlGetter::getSql('get_services_by_plan', ['plan_id' => $id]));
        foreach ($data as $key => $value) {
            $haveData2 = DB::select("SELECT 1 FROM health_plan_contracts WHERE health_plan_id = {$data[$key]->plan_id}");
            $data[$key]->isNotDeletable = isset($haveData2[0]);
        }
        return view('health_plan.services', ['data' => $data, 'plan_id' => $id]);
    }


    public function service_create(int $id)
    {
        $services = DB::select(SqlGetter::getSql('get_services_to_save_plan', ['plan_id' => $id]));
        return view('health_plan.service_create', ['services' => $services, 'plan_id' => $id]);
    }

    public function service_store(Request $req)
    {
        $controller = new HealthPlanServiceController();
        $ret = $controller->store($req)->getData();
        if ($ret->success) {
            return redirect('/health_plan/services/' . $req->health_plan_id);
        }
        return $this->service_create($ret->message);
    }

    public function service_destroy(Request $req)
    {
        $controller = new HealthPlanServiceController();
        $ret = $controller->destroy($req)->getData();
        if ($ret->success) {
            return redirect('/health_plan/services/' . $req->health_plan_id);
        }
        return $this->index($ret->message);
    }
}
