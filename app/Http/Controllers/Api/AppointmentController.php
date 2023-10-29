<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activation;
use App\Models\Appointment;
use App\Utils\SqlGetter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{

    public function list()
    {
        $appointments = DB::table('appointments')
            ->leftJoin('activations', 'appointments.activation_id', '=', 'activations.id')
            ->leftJoin('appointment_status', 'appointments.status_id', '=', 'appointment_status.id')
            ->select('appointments.*', 'appointment_status.description as status')
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $appointments], 200);
    }

    public function show(string $id)
    {
        $appointment = DB::table('appointments')
            ->leftJoin('activations', 'appointments.activation_id', '=', 'activations.id')
            ->leftJoin('appointment_status', 'appointments.status_id', '=', 'appointment_status.id')
            ->select('appointments.*', 'appointment_status.description as status')
            ->where([['appointments.id', '=', $id]])
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $appointment], !empty($appointment) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $vetId = DB::select('select a.veterinarian_id from activations a where a.id = ? limit 1', [$request->activation_id])[0]->veterinarian_id;
            $isNotAvailable = DB::select(SqlGetter::getSql('vet_is_available'), [$vetId, $request->date, $request->end_date]);
            if(!empty($isNotAvailable)) {
                return response()->json(['success' => false, 'message' => 'Horário indisponível!'], 200);
            }
            $appointment = new Appointment();
            $appointment->status_id = $request->status_id;
            $appointment->activation_id = $request->activation_id;
            $appointment->value = $request->value;
            $appointment->date = $request->date;
            $appointment->end_date = $request->end_date;
            if($appointment->save()) {
                $activation = Activation::find($request->activation_id);
                $activation->update(['activation_status_id' => 1]);
            }
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Houve um erro ao aceitar. Tente novamente mais tarde.'], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $appointment = Appointment::find($request->id);
            $appointment->update($dados);
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $appointment = Appointment::find($request->id);
            if (isset($appointment)) {
                $appointment->delete();
            }
            return response()->json(['success' => true, 'message' => ""], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByActivation(int $id)
    {
        $appointment = $this->getBy('appointments', 'activation_id', $id);
        return response()->json(['success' => true, 'message' => "", "dados" => $appointment], count($appointment) >= 1 ? 200 : 404);
    }

    public function getBy(string $table, string $field, $value)
    {
        $appointment =  DB::table('appointments')
        ->leftJoin('activations', 'appointments.activation_id', '=', 'activations.id')
        ->leftJoin('appointment_status', 'appointments.status_id', '=', 'appointment_status.id')
        ->select('appointments.*', 'appointment_status.description as status')
        ->where([[$table.'.'.$field, '=', $value]])
        ->get();

        return $appointment;
    }
}
