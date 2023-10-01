<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Interfaces\WebInteface;
use App\Models\UserPhone;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller implements WebInteface
{

    private $apiController;

    public function __construct()
    {
        $this->apiController = new ApiUserController();
    }

    public function index()
    {
        return view('user.index', ['data' => $this->apiController->list()->getData()->dados]);
    }

    public function create()
    {
        $user_types = UserType::all();
        $situations = DB::select('SELECT * FROM situations');
        return view('user.create', ['user_types' => $user_types, 'situations' => $situations]);
    }

    public function edit(int $id)
    {
        $user_types = UserType::all();
        $situations = DB::select('SELECT * FROM situations');
        return view('user.edit', ['user_types' => $user_types, 'situations' => $situations, 'data' => $this->apiController->show($id)->getData()->dados[0]]);
    }

    public function store(Request $req)
    {
        $authController = new AuthController();
        $ret = $authController->register($req)->getData();
        if (!$ret->success) {
            $user_types = UserType::all();
            $situations = DB::select('SELECT * FROM situations');
            return view('user.create', ['user_types' => $user_types, 'situations' => $situations, 'error' => $ret->message]);
        }

        UserPhone::create([
            'user_id' => $ret->dados->id,
            'ddd' => $req->ddd,
            'number' => $req->number
        ]);

        $req->merge(['user_id' => $ret->dados->id]);
        $retEnv = $this->apiController->sendImage($req)->getData();
        if (!$retEnv->success) {
            $user_types = UserType::all();
            $situations = DB::select('SELECT * FROM situations');
            return view('user.create', ['user_types' => $user_types, 'situations' => $situations, 'error' => $ret->message]);
        }
        return redirect('/user');
    }


    public function update(Request $req)
    {
        $req->merge(['user_id' => $req->id]);
        $newReq = $req->password == '00000000' ? $req->except('password') : $req->all();
        $newReq = new Request($newReq);
        $ret = $this->apiController->update($newReq)->getData();
        if (!$ret->success) {
            $user_types = UserType::all();
            $situations = DB::select('SELECT * FROM situations');
            return view('user.edit', ['user_types' => $user_types, 'situations' => $situations, 'error' => $ret->message]);
        }

        if ($req->hasFile('foto_perfil')) {
            $retEnv = $this->apiController->sendImage($req)->getData();
            if (!$retEnv->success) {
                $user_types = UserType::all();
                $situations = DB::select('SELECT * FROM situations');
                return view('user.edit', ['user_types' => $user_types, 'situations' => $situations, 'error' => $ret->message]);
            }
        }

        if (empty($req->user_phone_id)) {
            UserPhone::create($req->except('id'));
        } else {
            UserPhone::find($req->user_phone_id)->update($req->except('id'));
        }


        return redirect('/user');
    }

    public function destroy(Request $req)
    {
        $ret = $this->apiController->destroy($req)->getData();
        if ($ret->success) {
            return redirect('/user');
        }
        return view('user.index', ['data' => $this->list()->getData()->dados, 'error' => $ret->message]);
    }
}
