<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface WebInteface {

    public function index();

    public function create();

    public function edit(int $id);

    public function webStore(Request $req);

    public function webUpdate(Request $req);

    public function webDestroy(Request $req);

}