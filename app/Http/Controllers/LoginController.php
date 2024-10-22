<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('/');
        } else {
            return view('login.index');
        }
    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');
        $user = User::where('email', '=', $credentials['email'])->get();
        if(isset($user[0]) && $user[0]->user_type_id == 2 && $user[0]->situation_id == 1) {
            if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
                return view('home.home', ['user' => $user[0]]);
            }
        }
        return view('login.index', ['msg' => "Usuário não autenticado!"]);
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }

}