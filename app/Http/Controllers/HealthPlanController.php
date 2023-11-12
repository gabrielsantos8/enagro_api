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
    }

    public function edit(int $id, $err = "")
    {
    }

    public function store(Request $req)
    {
    }

    public function update(Request $req)
    {
    }

    public function destroy(Request $req)
    {
    }
}
