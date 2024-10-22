<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserType;
use Exception;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    public function list()
    {
        $user_types = UserType::all();
        return response()->json(['success' => true, 'message' => "", "dados" => $user_types], 200);
    }

    public function store(Request $request)
    {
        try {
            $user_type = new UserType();
            $user_type->description = $request->description;
            if ($user_type->save()) {
                return response()->json(['success' => true, 'message' => "Tipo de usuário cadastrado!", 'dados' => $user_type], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        $user_type = UserType::find($id);
        return response()->json(['success' => true, 'message' => !empty($user_type) ? "" : "Tipo de usuário não encontrado!", "dados" => $user_type], !empty($user_type) ? 200 : 404);
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $user_type = UserType::find($request->id);
            $user_type->update($dados);
            return response()->json(['success' => true, 'message' => 'Tipo de usuário atualizado!'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $user_type = UserType::find($request->id);
            $user_type->delete();
            return response()->json(['success' => true, 'message' => "Tipo de usuário excluído!"], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
