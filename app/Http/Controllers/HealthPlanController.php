<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\HealthPlanController as ApiHealthPlanController;
use Illuminate\Http\Request;

class HealthPlanController extends Controller
{
    private $apiController;

    public function __construct()
    {
        $this->apiController = new ApiHealthPlanController();
    }

    public function index($err = "")
    {
        return view('health_plan.index', ['data' => $this->apiController->list()->getData()->dados, "error" => $err]);
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
    }

    public function update(Request $req)
    {
    }

    public function destroy(Request $req)
    {
        $ret = $this->apiController->destroy($req)->getData();
        if ($ret->success) {
            return redirect('/health_plan');
        }
        return $this->index($ret->message);
    }
}
