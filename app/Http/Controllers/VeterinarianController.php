<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\VeterinarianController as ApiVeterinarianController;
use App\Http\Interfaces\WebInteface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VeterinarianController extends Controller
{

    private $apiController;

    public function __construct()
    {
        $this->apiController = new ApiVeterinarianController();
    }

    public function index($err = "")
    {
        return view('veterinarian.index', ['dados' => $this->apiController->list()->getData()->dados, "error" => $err]);
    }

    public function create($err = "")
    {
        $cityController = new CityController();
        $query = "SELECT 
                        u.*
                  FROM users u 
                  WHERE NOT EXISTS (select 1 from veterinarians v where v.user_id = u.id)";
        $users = DB::select($query);
        return view('veterinarian.create', ['users' => $users, 'ufs' => $cityController->getUfs()->getData()->dados, 'error' => $err]);
    }

    public function edit(int $id, $err = "")
    {
        $cityController = new CityController();
        $query = "SELECT 
                        u.*
                  FROM users u";
        $users = DB::select($query);
        $dados = $this->apiController->show($id)->getData()->dados[0];
        return view('veterinarian.edit', ['dados' => $dados, 'users' => $users, 'ufs' => $cityController->getUfs()->getData()->dados, 'error' => $err]);
    }

    public function store(Request $req)
    {
        $ret = $this->apiController->store($req)->getData();
        if ($ret->success) {
            return $this->index();
        }
        return $this->create($ret->message);
    }

    public function update(Request $req)
    {
        $ret = $this->apiController->update($req)->getData();
        if ($ret->success) {
            return $this->index();
        }
        return $this->edit($req->id, $ret->message);
    }

    public function destroy(Request $req)
    {
        $ret = $this->apiController->destroy($req)->getData();
        if ($ret->success) {
            return $this->index();
        }
        return $this->index($ret->message);
    }
}
