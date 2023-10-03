<?php

namespace App\Http\Controllers;

use  App\Http\Controllers\Api\AnimalController as ApiAnimalController;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;

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
