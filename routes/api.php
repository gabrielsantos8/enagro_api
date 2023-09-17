<?php

use App\Http\Controllers\Api\AnimalController;
use App\Http\Controllers\Api\AnimalSubtypeController;
use App\Http\Controllers\Api\AnimalTypeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\HealthInsuranceController;
use App\Http\Controllers\Api\ServiceCityController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UserAddressController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserPhoneController;
use App\Http\Controllers\Api\UserTypeController;
use App\Http\Controllers\Api\VeterinarianController;
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
    Route::get('/getImage/{id}', [UserController::class, 'getImage']);
    Route::get('/removeImage/{id}', [UserController::class, 'removeImage']);
    Route::post('/sendImage', [UserController::class, 'sendImage']);
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
    Route::get('/getComboByUser/{id}', [UserAddressController::class, 'getComboByUser']);
});

Route::prefix('user_phone')->group(function () {
    Route::post('/store', [UserPhoneController::class, 'store']);
    Route::get('/', [UserPhoneController::class, 'list']);
    Route::get('/show/{id}', [UserPhoneController::class, 'show']);
    Route::post('/update', [UserPhoneController::class, 'update']);
    Route::post('/destroy', [UserPhoneController::class, 'destroy']);
    Route::get('/getByUser/{id}', [UserPhoneController::class, 'getByUser']);
});


Route::prefix('archives')->group(function () {
    Route::post('/upload', [FileUploadController::class, 'upload']);
});

Route::prefix('veterinarian')->group(function () {
    Route::post('/store', [VeterinarianController::class, 'store']);
    Route::get('/show/{id}', [VeterinarianController::class, 'show']);
    Route::get('/', [VeterinarianController::class, 'list']);
    Route::post('/update', [VeterinarianController::class, 'update']);
    Route::post('/destroy', [VeterinarianController::class, 'destroy']);
    Route::get('/getByUser/{id}', [VeterinarianController::class, 'getByUser']);
});

Route::prefix('service_city')->group(function () {
    Route::post('/store', [ServiceCityController::class, 'store']);
    Route::get('/show/{id}', [ServiceCityController::class, 'show']);
    Route::get('/', [ServiceCityController::class, 'list']);
    Route::post('/update', [ServiceCityController::class, 'update']);
    Route::post('/destroy', [ServiceCityController::class, 'destroy']);
    Route::get('/getByVeterinarian/{id}', [ServiceCityController::class, 'getByVeterinarian']);
    Route::get('/getByUf/{id}/{uf}', [ServiceCityController::class, 'getByUf']);
});

Route::prefix('animal_type')->group(function () {
    Route::get('/', [AnimalTypeController::class, 'list']);
    Route::post('/store', [AnimalTypeController::class, 'store']);
    Route::post('/update', [AnimalTypeController::class, 'update']);
    Route::post('/destroy', [AnimalTypeController::class, 'destroy']);
    Route::get('/show/{id}', [AnimalTypeController::class, 'show']);
});

Route::prefix('animal_subtype')->group(function () {
    Route::get('/', [AnimalSubtypeController::class, 'list']);
    Route::post('/store', [AnimalSubtypeController::class, 'store']);
    Route::post('/update', [AnimalSubtypeController::class, 'update']);
    Route::post('/destroy', [AnimalSubtypeController::class, 'destroy']);
    Route::get('/show/{id}', [AnimalSubtypeController::class, 'show']);
    Route::get('/getByAnimalType/{id}', [AnimalSubtypeController::class, 'getByAnimalType']);
});

Route::prefix('animal')->group(function () {
    Route::get('/', [AnimalController::class, 'list']);
    Route::post('/store', [AnimalController::class, 'store']);
    Route::post('/update', [AnimalController::class, 'update']);
    Route::post('/destroy', [AnimalController::class, 'destroy']);
    Route::get('/show/{id}', [AnimalController::class, 'show']);
    Route::get('/getByUser/{id}', [AnimalController::class, 'getByUser']);
    Route::get('/getImage/{id}', [AnimalController::class, 'getImage']);
    Route::get('/removeImage/{id}', [AnimalController::class, 'removeImage']);
    Route::post('/sendImage', [AnimalController::class, 'sendImage']);
});

Route::prefix('health_insurance')->group(function () {
    Route::get('/', [HealthInsuranceController::class, 'list']);
    Route::post('/store', [HealthInsuranceController::class, 'store']);
    Route::post('/update', [HealthInsuranceController::class, 'update']);
    Route::post('/destroy', [HealthInsuranceController::class, 'destroy']);
    Route::get('/show/{id}', [HealthInsuranceController::class, 'show']);
});

Route::prefix('service')->group(function () {
    Route::get('/', [ServiceController::class, 'list']);
    Route::post('/store', [ServiceController::class, 'store']);
    Route::post('/update', [ServiceController::class, 'update']);
    Route::post('/destroy', [ServiceController::class, 'destroy']);
    Route::get('/show/{id}', [ServiceController::class, 'show']);
    Route::get('/getByAnimalSubtype/{id}', [ServiceController::class, 'getByAnimalSubtype']);
});