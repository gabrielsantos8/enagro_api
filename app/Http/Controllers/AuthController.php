<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = User::where('email', '=', $credentials['email'])->get();
            $token = $this->generateJWTToken($user[0]['id'], $user[0]['name'], $user[0]['email'], $user[0]['user_type_id'], $user[0]['user_type']);
            return response()->json(['success' => true, 'message' => "Usuário autenticado!", 'token' =>  $token, 'dados' => $user[0]], 200);
        }
        return response()->json(['success' => false, 'message' => "Usuário não autenticado!", 'dados' => json_decode('{}')], 200);
    }

    public function register(Request $request)
    {
        try {

            if($this->emailExists($request->email)) {
                return response()->json(['success' => false, 'message' => "Email inválido!"], 200);
            }

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->user_type_id = ($request->user_type_id) ? $request->user_type_id : 1;
            if ($user->save()) {
                return response()->json(['success' => true, 'message' => "Usuário cadastrado!", 'dados' => $user[0]], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'dados' => json_decode('{}')], 500);
        }
    }

    public function emailExists(string $email) {
        $e = User::where('email', '=', $email)->get();
        return !empty(json_decode($e));
    }

    function generateJWTToken($userId, $username, $email, $userTypeId, $userType) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 604800; // 1 semana de expiração
    
        $payload = array(
            "id" => $userId,
            "name" => $username,
            "email" => $email,
            "user_type_id" => $userTypeId,
            "user_type" => $userType,
            "iat" => $issuedAt,
            "exp" => $expirationTime
        );
    
        $secretKey = getenv('APP_KEY');
    
        $jwt = JWT::encode($payload, $secretKey, 'HS256');
    
        return $jwt;
    }
    
}
