<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'index']);

Route::get('/home', [HomeController::class, 'index'])->name('home.index');

Route::post('/login', [LoginController::class, 'login'])->name('login.logar');

Route::get('/sair', [LoginController::class, 'logout'])->name('login.sair');