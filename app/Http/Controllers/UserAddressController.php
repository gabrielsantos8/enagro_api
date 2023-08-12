<?php

namespace App\Http\Controllers;

use App\Models\City;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAddressController extends Controller
{
    public function list()
    {
        $cities = DB::table('user_addresses')
            ->join('cities', 'user_addresses.city_id', '=', 'cities.id')
            ->select('user_addresses.id', 'user_addresses.complement', 'cities.description as city', 'cities.uf', 'cities.ibge')
            ->get();
        return response()->json(['success' => true, 'message' => "", "dados" => $cities], 200);
    }

}
