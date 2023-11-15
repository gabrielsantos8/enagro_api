<?php

namespace App\Http\Controllers;

use  App\Http\Controllers\Api\AnimalController as ApiAnimalController;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\AnimalSubtype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AnimalType;
use App\Models\UserAddress;

class AnimalController extends Controller
{
    private $apiController;

    public function __construct()
    {
        $this->apiController = new ApiAnimalController();
    }

    public function index()
    {
        return view('animal.index', ['data' => $this->apiController->list()->getData()->dados]);
    }

    public function create()
    {
        $animal_subtypes = AnimalSubtype::all();
        $user_address = UserAddress::all();
        return view('animal.create', ['animal_subtypes' => $animal_subtypes, 'user_address' => $user_address]);
    }

    public function update(Request $req) 
    {
        $ret = $this->apiController->update($req)->getData();
        if ($ret->success) {
            return redirect('/animal');
        }
        return $this->edit($req->id, $ret->message);

        
    }

    public function edit(int $id)
    {
        $animal_subtypes = AnimalSubtype::all();
        $user_address = UserAddress::all();
        return view('animal.edit', ['animal_subtypes' => $animal_subtypes, 'user_address' => $user_address, 'data' => $this->apiController->show($id)->getData()->dados[0]]);
    }

    public function store(Request $req)
    {
        
        $ret = $this->apiController->store($req)->getData();
        if ($ret->success) {
            return redirect('/animal');
        }
        
        return $this->create($ret->message);
    }

    public function destroy(Request $req)
    {
        $ret = $this->apiController->destroy($req)->getData();
        if ($ret->success) {
            return redirect('/animal');
        }
        return view('animal.index', ['data' => $this->list()->getData()->dados, 'error' => $ret->message]);
    }
}
