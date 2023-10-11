<?php

namespace App\Http\Controllers;

use  App\Http\Controllers\Api\AnimalController as ApiAnimalController;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AnimalType;

class AnimalController extends Controller
{
    private $apiController;

    public function __construct()
    {
        $this->apiController = new ApiAnimalController();
    }

    public function index()
    {
        return view('animal.index', ['data' => $this->apiController->list()->getData()->dados]);
    }

    public function create()
    {
        $animal_types = AnimalType::all();
        $situations = DB::select('SELECT * FROM situations');
        return view('animal.create', ['animal_types' => $animal_types, 'situations' => $situations]);
    }

    public function edit(int $id)
    {
       
    }

    public function store(Request $req)
    {
        
    }

    public function destroy(Request $req)
    {
    
    }
}
