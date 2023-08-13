<?php

namespace App\Http\Controllers;

use App\Models\UserPhone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserPhoneController extends Controller
{
    public function list()
    {
        $userPhones = DB::table('user_phones')
            ->join('users', 'user_phones.user_id', '=', 'users.id')
            ->select('user_phones.*', 'users.name as user')
            ->get();
        return response()->json(['success' => true, 'message' => "", "dados" => $userPhones], 200);
    }

    public function show(string $id)
    {
        $userPhone = DB::table('user_phones')
            ->join('users', 'user_phones.user_id', '=', 'users.id')
            ->select('user_phones.*', 'users.name as user')
            ->where('user_phones.id', '=', $id)
            ->get();
        return response()->json(['success' => true, 'message' => "", "dados" => $userPhone], !empty($userPhone) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $userPhone = new UserPhone();
            $userPhone->ddd = $request->ddd;
            $userPhone->number = $request->number;
            $userPhone->user_id = $request->user_id;
            if ($userPhone->save()) {
                return response()->json(['success' => true, 'message' => "Telefone cadastrado!", 'dados' => $userPhone], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $userPhone = UserPhone::find($request->id);
            $userPhone->update($dados);
            return response()->json(['success' => true, 'message' => 'Telefone atualizado!'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $userPhone = UserPhone::find($request->id);
            $userPhone->delete();
            return response()->json(['success' => true, 'message' => "Telefone excluído!"], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByUser(int $id)
    {
        $userPhone = $this->getBy('user_id', $id);
        return response()->json(['success' => true, 'message' => "", "dados" => $userPhone], count($userPhone) >= 1 ? 200 : 404);
    }

    public function getBy(string $field, $value)
    {
        $userPhone = DB::table('user_phones')
            ->join('users', 'user_phones.user_id', '=', 'users.id')
            ->select('user_phones.*', 'users.name as user')
            ->where('user_phones.' . $field, '=', $value)
            ->get();
        return $userPhone;
    }
}
