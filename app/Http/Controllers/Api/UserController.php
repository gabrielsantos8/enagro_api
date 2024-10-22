<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function list()
    {
        $userAddressController = new UserAddressController;

        $users = DB::table('users')
            ->leftJoin('user_types', 'users.user_type_id', '=', 'user_types.id')
            ->leftJoin('user_phones', 'user_phones.user_id', '=', 'users.id')
            ->leftJoin('situations', 'users.situation_id', '=', 'situations.id')
            ->select('users.id', 'users.situation_id', 'users.name', 'situations.description as situation', 'users.email', 'users.email_verified_at', 'users.user_type_id', 'users.image_url', 'users.updated_at', 'users.created_at', 'user_types.description as user_type', 'user_phones.id as user_phone_id', 'user_phones.ddd', 'user_phones.number')
            ->get();

        foreach ($users as $key => $value) {
            $haveData = DB::select("SELECT 1 FROM health_plan_contracts WHERE user_id = {$users[$key]->id}");
            $users[$key]->addresses = $userAddressController->getBy('user_id', $users[$key]->id);
            $users[$key]->isNotDeletable = isset($haveData[0]);
        }

        return response()->json(['success' => true, 'message' => "", "dados" => $users], 200);
    }

    public function show(string $id)
    {
        $userAddressController = new UserAddressController;

        $user = DB::table('users')
            ->leftJoin('user_types', 'users.user_type_id', '=', 'user_types.id')
            ->leftJoin('user_phones', 'user_phones.user_id', '=', 'users.id')
            ->leftJoin('situations', 'users.situation_id', '=', 'situations.id')
            ->select('users.id', 'users.situation_id', 'users.name', 'situations.description as situation', 'users.email', 'users.email_verified_at', 'users.user_type_id', 'users.image_url', 'users.updated_at', 'users.created_at', 'user_types.description as user_type', 'user_phones.id as user_phone_id', 'user_phones.ddd', 'user_phones.number')
            ->where([['users.id', '=', $id]])
            ->get();

        foreach ($user as $key => $value) {
            $haveData = DB::select("SELECT 1 as yes FROM health_plan_contracts WHERE user_id = {$user[$key]->id}");
            $user[$key]->addresses = $userAddressController->getBy('user_id', $user[$key]->id);
            $user[$key]->isNotDeletable = isset($haveData[0]);
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
