<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        // $user = new User();
        // $user->name = 'admin';
        // $user->email = 'admin@gmail.com';
        // $user->password = Hash::make('admin123');
        // $user->user_type_id = 2;
        // $user->save();

        if (Auth::check()) {
            return view('home.home');
        } else {
            return view('login.index');
        }
    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $user = User::where('email', '=', $credentials['email'])->get();
            return view('home.home');
        }
        return view('login.index', ['msg' => "Usuário não autenticado!"]);
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }

    public function cadastrar() {
        //  $user = new User();
        //  $user->name = 'admin';
        //  $user->email = 'admin@gmail.com';
        //  $user->password = Hash::make('admin123');
        //  $user->user_types = 2;
        //  $user->save();
    }
}