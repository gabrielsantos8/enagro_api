<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return redirect('/');
        }
        $user = Auth::user();
        $home = $this->list();
        return View('home.index', ['home$home' => $home, 'user' => $user]);
    }
}
