<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAddress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function list()
    {
        $userAddressController = new UserAddressController;

        $users = DB::table('users')
            ->join('user_types', 'users.user_type_id', '=', 'user_types.id')
            ->join('user_phones', 'user_phones.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.email', 'users.email_verified_at', 'users.user_type_id', 'user_types.description as user_type', 'user_phones.ddd', 'user_phones.number')
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
            ->join('user_types', 'users.user_type_id', '=', 'user_types.id')
            ->join('user_phones', 'user_phones.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.email', 'users.email_verified_at', 'users.user_type_id', 'user_types.description as user_type', 'user_phones.ddd', 'user_phones.number')
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
}
