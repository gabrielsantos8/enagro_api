<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAddressController extends Controller
{
    public function list()
    {
        $userAddress = DB::table('user_addresses')
            ->join('cities', 'user_addresses.city_id', '=', 'cities.id')
            ->join('users', 'user_addresses.user_id', '=', 'users.id')
            ->select('user_addresses.*', 'cities.description as city', 'cities.uf', 'cities.ibge', 'users.name as user')
            ->get();
        return response()->json(['success' => true, 'message' => "", "dados" => $userAddress], 200);
    }

    public function show(string $id)
    {
        $userAddress = DB::table('user_addresses')
            ->join('cities', 'user_addresses.city_id', '=', 'cities.id')
            ->join('users', 'user_addresses.user_id', '=', 'users.id')
            ->select('user_addresses.*', 'cities.description as city', 'cities.uf', 'cities.ibge', 'users.name as user')
            ->where('user_addresses.id', '=', $id)
            ->get();
        return response()->json(['success' => true, 'message' => "", "dados" => $userAddress], !empty($userAddress) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $userAddress = new UserAddress();
            $userAddress->complement = $request->complement;
            $userAddress->user_id = $request->user_id;
            $userAddress->city_id = $request->city_id;
            if ($userAddress->save()) {
                return response()->json(['success' => true, 'message' => "Endereço cadastrado!", 'dados' => $userAddress], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $userAddress = UserAddress::find($request->id);
            $userAddress->update($dados);
            return response()->json(['success' => true, 'message' => 'Endereço atualizado!'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $userAddress = UserAddress::find($request->id);
            $userAddress->delete();
            return response()->json(['success' => true, 'message' => "Endereço excluído!"], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByUser(int $id)
    {
        $userAddresses = $this->getBy('user_id', $id);
        return response()->json(['success' => true, 'message' => "", "dados" => $userAddresses], count($userAddresses) >= 1 ? 200 : 404);
    }

    public function getComboByUser(int $id)
    {
        $query = "select 
                     cast(ua.id as integer) as id 
                    ,ua.complement
                    ,c.description as city
                    ,c.uf 
                from user_addresses ua
                left join cities c on c.id = ua.city_id
                where ua.user_id = ?
                
                union all
                
                select
                     0
                    ,'' as complement
                    ,'Selecione...' as city
                    ,'' as uf
       ";
        $userAddresses = DB::select($query, [$id]);
        return response()->json(['success' => true, 'message' => "", "dados" => $userAddresses], count($userAddresses) >= 1 ? 200 : 404);
    }

    public function getBy(string $field, $value)
    {
        $userAddress = DB::table('user_addresses')
            ->join('cities', 'user_addresses.city_id', '=', 'cities.id')
            ->join('users', 'user_addresses.user_id', '=', 'users.id')
            ->select('user_addresses.*', 'cities.description as city', 'cities.uf', 'cities.ibge', 'users.name as user')
            ->where('user_addresses.' . $field, '=', $value)
            ->get();
        return $userAddress;
    }
}
