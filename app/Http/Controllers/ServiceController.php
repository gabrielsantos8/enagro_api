<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ServiceController as ApiServiceController;
use App\Models\AnimalSubtype;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private $apiController;

    public function __construct()
    {
        $this->apiController = new ApiServiceController();
    }


    public function index()
    {
        $apiData = $this->apiController->list()->getData()->dados;
        return view('service.index', ['data' => $apiData]);
    }


    public function create($err = "")
    {
        $animalSubtypes = AnimalSubtype::all();
        return view('service.create', ["error" => $err, 'animal_subtypes' => $animalSubtypes]);
    }

    public function store(Request $req)
    {
        $ret = $this->apiController->store($req)->getData();
        if ($ret->success) {
            return redirect('/service');
        }
        return $this->create($ret->message);
    }

    public function edit(int $id, $err = "")
    {
        $animalSubtypes = AnimalSubtype::all();
        $data = $this->apiController->show($id)->getData()->dados[0];
        return view('service.edit', ['data' => $data, 'animal_subtypes' => $animalSubtypes, 'error' => $err]);
    }


    public function update(Request $req)
    {
        $ret = $this->apiController->update($req)->getData();
        if ($ret->success) {
            return redirect('/service');
        }
        return $this->edit($req->id, $ret->message);
    }

    public function destroy(Request $req)
    {
        $ret = $this->apiController->destroy($req)->getData();
        if ($ret->success) {
            return redirect('/service');
        }
        return $this->index($ret->message);
    }
}
