<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\WebInteface;
use App\Models\User;
use App\Models\UserPhone;
use App\Models\UserType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller implements WebInteface
{

    public function index()
    {
        return view('user.index', ['user' => Auth::user(), 'dados' => $this->list()->getData()->dados]);
    }

    public function create()
    {
        $user_types = UserType::all();
        return view('user.create', ['user' => Auth::user(), 'user_types' => $user_types]);
    }

    public function edit(int $id)
    {
        $user_types = UserType::all();
        return view('user.edit', ['user' => Auth::user(), 'user_types' => $user_types, 'dados' => $this->show($id)->getData()->dados[0]]);
    }

    public function webStore(Request $req)
    {
        $authController = new AuthController();
        $ret = $authController->register($req)->getData();
        if (!$ret->success) {
            $user_types = UserType::all();
            return view('user.create', ['user' => Auth::user(), 'user_types' => $user_types, 'error' => $ret->message]);
        }

        UserPhone::create([
            'user_id' => $ret->dados->id,
            'ddd' => $req->ddd,
            'number' => $req->number
        ]);

        $req->merge(['user_id' => $ret->dados->id]);
        $retEnv = $this->sendImage($req)->getData();
        if (!$retEnv->success) {
            $user_types = UserType::all();
            return view('user.create', ['user' => Auth::user(), 'user_types' => $user_types, 'error' => $ret->message]);
        }
        return redirect('/user');
    }


    public function webUpdate(Request $req)
    {
        $req->merge(['user_id' => $req->id]);
        $newReq = $req->password == '00000000' ? $req->except('password') : $req->all();
        $newReq = new Request($newReq);
        $ret = $this->update($newReq)->getData();
        if (!$ret->success) {
            $user_types = UserType::all();
            return view('user.edit', ['user' => Auth::user(), 'user_types' => $user_types, 'error' => $ret->message]);
        }

        if ($req->hasFile('foto_perfil')) {
            $retEnv = $this->sendImage($req)->getData();
            if (!$retEnv->success) {
                $user_types = UserType::all();
                return view('user.edit', ['user' => Auth::user(), 'user_types' => $user_types, 'error' => $ret->message]);
            }
        }

        if (empty($req->user_phone_id)) {
            UserPhone::create($req->except('id'));
        } else {
            UserPhone::find($req->user_phone_id)->update($req->except('id'));
        }
        

        return redirect('/user');
    }

    public function webDestroy(Request $req)
    {
        $ret = $this->destroy($req)->getData();
        if ($ret->success) {
            return redirect('/user');
        }
        return view('user.index', ['dados' => $this->list()->getData()->dados, 'user' => Auth::user(), 'error' => $ret->message]);
    }

    public function list()
    {
        $userAddressController = new UserAddressController;

        $users = DB::table('users')
            ->leftJoin('user_types', 'users.user_type_id', '=', 'user_types.id')
            ->leftJoin('user_phones', 'user_phones.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.email', 'users.email_verified_at', 'users.user_type_id', 'users.image_url', 'users.updated_at', 'users.created_at', 'user_types.description as user_type', 'user_phones.id as user_phone_id', 'user_phones.ddd', 'user_phones.number')
            ->get();

        foreach ($users as $key => $value) {
            $users[$key]->addresses = $userAddressController->getBy('user_id', $users[$key]->id);
        }

        return response()->json(['success' => true, 'message' => "", "dados" => $users], 200);
    }

    public function show(string $id)
    {
        $userAddressController = new UserAddressController;

        $user = DB::table('users')
            ->leftJoin('user_types', 'users.user_type_id', '=', 'user_types.id')
            ->leftJoin('user_phones', 'user_phones.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.email', 'users.email_verified_at', 'users.user_type_id', 'users.image_url', 'user_types.description as user_type', 'user_phones.id as user_phone_id', 'user_phones.ddd', 'user_phones.number')
            ->where([['users.id', '=', $id]])
            ->get();

        foreach ($user as $key => $value) {
            $user[$key]->addresses = $userAddressController->getBy('user_id', $user[$key]->id);
        }

        return response()->json(['success' => true, 'message' => !empty($user) ? "" : "Usuário não encontrado!", "dados" => $user], !empty($user) ? 200 : 404);
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $user = User::find($request->id);
            $user->update($dados);
            return response()->json(['success' => true, 'message' => 'Usuário atualizado!'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $user = User::find($request->id);
            $user->delete();
            return response()->json(['success' => true, 'message' => "Usuário excluído!"], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getImage(int $id)
    {
        try {
            $user = User::find($id);
            if (!empty($user->image_url)) {
                return response()->json(['success' => true, 'message' => "", 'image_url' => $user->image_url], 200);
            }
            return response()->json(['success' => false, 'message' => "Nenhuma imagem encontrada"], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }

    public function removeImage(int $id)
    {
        try {
            $user = User::find($id);
            $user->update(['image_url' => null]);
            return response()->json(['success' => true, 'message' => ""], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }

    public function sendImage(Request $request)
    {
        $fileCtrl = new FileUploadController();
        try {
            $fileCtrl->upload($request);
            return response()->json(['success' => true, 'message' => ""], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }
}
