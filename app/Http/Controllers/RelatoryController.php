<?php

namespace App\Http\Controllers;

use App\Utils\SqlGetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatoryController extends Controller
{
    public function plansByRegionIndex($data = []) {
        $status = DB::select('SELECT * FROM health_plan_contract_status');
        $ufs = DB::select('SELECT c.uf FROM cities c GROUP BY 1');
        return view('relatory.plans_by_region', ['status' => $status, 'ufs' => $ufs]);
    }

    public function plansByRegionData(Request $req) {
        $params = $req->except('_token');
        $data = DB::select(SqlGetter::getSql('rel_plans_by_uf_status', $params));
        return response()->json(['success' => true, 'message' => "", 'dados' => $data], 200);
    }
}
