<?php

namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface WebInteface {

    public function index();

    public function create();

    public function edit(int $id);

    public function store(Request $req);

    public function update(Request $req);

    public function destroy(Request $req);

}