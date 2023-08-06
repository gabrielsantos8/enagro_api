<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('user_type')->group(function () {
    Route::get('/', [UserTypeController::class, 'list']);
    Route::post('/store', [UserTypeController::class, 'store']);
    Route::post('/update', [UserTypeController::class, 'update']);
    Route::post('/destroy', [UserTypeController::class, 'destroy']);
    Route::get('/show/{id}', [UserTypeController::class, 'show']);
});

Route::prefix('user')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/store', [AuthController::class, 'register']);
    Route::get('/', [UserController::class, 'list']);
    Route::get('/show/{id}', [UserController::class, 'show']);
    Route::post('/update', [UserController::class, 'update']);
    Route::post('/destroy', [UserController::class, 'destroy']);
});
