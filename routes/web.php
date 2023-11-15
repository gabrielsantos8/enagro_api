<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\HealthPlanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RelatoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\VeterinarianController;
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

Route::get('/login', [LoginController::class, 'index'])->name('login');

Route::get('/', [HomeController::class, 'index'])->name('home.index')->middleware('auth');

Route::post('/login', [LoginController::class, 'login'])->name('login.logar');

Route::get('/sair', [LoginController::class, 'logout'])->name('login.sair');


Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/store', [UserController::class, 'store'])->name('user.store');
    Route::post('/update', [UserController::class, 'update'])->name('user.update');
    Route::post('/destroy', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::prefix('user_type')->middleware('auth')->group(function () {
    Route::get('/', [UserTypeController::class, 'index'])->name('user_type.index');
    Route::get('/create', [UserTypeController::class, 'create'])->name('user_type.create');
    Route::get('/edit/{id}', [UserTypeController::class, 'edit'])->name('user_type.edit');
    Route::post('/store', [UserTypeController::class, 'store'])->name('user_type.store');
    Route::post('/update', [UserTypeController::class, 'update'])->name('user_type.update');
    Route::post('/destroy', [UserTypeController::class, 'destroy'])->name('user_type.destroy');
});


Route::prefix('veterinarian')->middleware('auth')->group(function () {
    Route::get('/', [VeterinarianController::class, 'index'])->name('veterinarian.index');
    Route::get('/create', [VeterinarianController::class, 'create'])->name('veterinarian.create');
    Route::get('/edit/{id}', [VeterinarianController::class, 'edit'])->name('veterinarian.edit');
    Route::post('/store', [VeterinarianController::class, 'store'])->name('veterinarian.store');
    Route::post('/update', [VeterinarianController::class, 'update'])->name('veterinarian.update');
    Route::post('/destroy', [VeterinarianController::class, 'destroy'])->name('veterinarian.destroy');
});

Route::prefix('animal')->middleware('auth')->group(function () {
    Route::get('/', [AnimalController::class, 'index'])->name('animal.index');
    Route::get('/create', [AnimalController::class, 'create'])->name('animal.create');
    Route::get('/edit/{id}', [AnimalController::class, 'edit'])->name('animal.edit');
    Route::post('/store', [AnimalController::class, 'store'])->name('animal.store');
    Route::post('/update', [AnimalController::class, 'update'])->name('animal.update');
    Route::post('/destroy', [AnimalController::class, 'destroy'])->name('animal.destroy');
});

Route::prefix('relatory')->middleware('auth')->group(function () {
    Route::get('/plansByRegion', [RelatoryController::class, 'plansByRegionIndex'])->name('relatory.plansByRegionIndex');
    Route::get('/installmentByUser', [RelatoryController::class, 'installmentByUserIndex'])->name('relatory.installmentByUser');
    Route::get('/animalsBySubtype', [RelatoryController::class, 'animalsBySubtypeIndex'])->name('relatory.animalsBySubtype');
    Route::post('/plansByRegionData', [RelatoryController::class, 'plansByRegionData']);
    Route::post('/installmentByUserIndexData', [RelatoryController::class, 'installmentByUserIndexData']);
    Route::post('/animalsBySubtypeData', [RelatoryController::class, 'animalsBySubtypeData']);
});

Route::prefix('health_plan')->middleware('auth')->group(function () {
    Route::get('/', [HealthPlanController::class, 'index'])->name('health_plan.index');
    Route::get('/create', [HealthPlanController::class, 'create'])->name('health_plan.create');
    Route::post('/store', [HealthPlanController::class, 'store'])->name('health_plan.store');
    Route::get('/edit/{id}', [HealthPlanController::class, 'edit'])->name('health_plan.edit');
    Route::get('/services/{id}', [HealthPlanController::class, 'services'])->name('health_plan.services');
    Route::get('/service_create/{id}', [HealthPlanController::class, 'service_create'])->name('health_plan.service_create');
    Route::post('/service_store', [HealthPlanController::class, 'service_store'])->name('health_plan.service_store');
    Route::post('/service_destroy', [HealthPlanController::class, 'service_destroy'])->name('health_plan.service_destroy');
    Route::post('/update', [HealthPlanController::class, 'update'])->name('health_plan.update');
    Route::post('/destroy', [HealthPlanController::class, 'destroy'])->name('health_plan.destroy');
});

Route::prefix('service')->middleware('auth')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('service.index');
    Route::get('/create', [ServiceController::class, 'create'])->name('service.create');
    Route::post('/store', [ServiceController::class, 'store'])->name('service.store');
    Route::get('/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
    Route::post('/update', [ServiceController::class, 'update'])->name('service.update');
    Route::post('/destroy', [ServiceController::class, 'destroy'])->name('service.destroy');
});
