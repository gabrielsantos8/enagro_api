<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPhoneController;
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

Route::prefix('city')->group(function () {
    Route::post('/store', [CityController::class, 'store']);
    Route::get('/', [CityController::class, 'list']);
    Route::get('/show/{id}', [CityController::class, 'show']);
    Route::post('/update', [CityController::class, 'update']);
    Route::post('/destroy', [CityController::class, 'destroy']);
    Route::get('/getUfs', [CityController::class, 'getUfs']);
    Route::get('/getCities/{uf}', [CityController::class, 'getCities']);
});

Route::prefix('user_address')->group(function () {
    Route::post('/store', [UserAddressController::class, 'store']);
    Route::get('/', [UserAddressController::class, 'list']);
    Route::get('/show/{id}', [UserAddressController::class, 'show']);
    Route::post('/update', [UserAddressController::class, 'update']);
    Route::post('/destroy', [UserAddressController::class, 'destroy']);
    Route::get('/getByUser/{id}', [UserAddressController::class, 'getByUser']);
});

Route::prefix('user_phone')->group(function () {
    Route::post('/store', [UserPhoneController::class, 'store']);
    Route::get('/', [UserPhoneController::class, 'list']);
    Route::get('/show/{id}', [UserPhoneController::class, 'show']);
    Route::post('/update', [UserPhoneController::class, 'update']);
    Route::post('/destroy', [UserPhoneController::class, 'destroy']);
    Route::get('/getByUser/{id}', [UserPhoneController::class, 'getByUser']);
});