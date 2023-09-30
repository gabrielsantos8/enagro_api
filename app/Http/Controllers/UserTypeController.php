<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\UserTypeController as ApiUserTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTypeController extends Controller
{

    private $apiController;

    public function __construct()
    {
        $this->apiController = new ApiUserTypeController();
    }

    public function index()
    {
        $data = $this->apiController->list()->getData()->dados;
        return view('user_type.index', ['data' => $data, 'user' => Auth::user()]);
    }

    public function create()
    {
        return view('user_type.create', ['user' => Auth::user()]);
    }

    public function edit(int $id) {
        $usr_type = $this->apiController->show($id)->getData()->dados;
        return view('user_type.edit', ['usr_type'=>$usr_type,'user' => Auth::user()]);
    }

    public function store(Request $req)
    {
        $ret = $this->apiController->store($req)->getData();
        if ($ret->success) {
            return redirect('/user_type');
        }
        return view('user_type.create', ['error' => $ret->message]);
    }

    public function update(Request $req)
    {
        $ret = $this->apiController->update($req)->getData();
        if ($ret->success) {
            return redirect('/user_type');
        }
        return view('user_type.edit', ['error' => $ret->message]);
    }

    public function destroy(Request $req) {
        $ret = $this->apiController->destroy($req)->getData();
        if ($ret->success) {
            return redirect('/user_type');
        }
        return view('user_type.index', ['data' => $this->apiController->list()->getData()->dados, 'error' => $ret->message]);
    }
}
