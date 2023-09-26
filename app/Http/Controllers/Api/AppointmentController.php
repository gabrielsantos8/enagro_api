<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
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
            $appointment = new Appointment();
            $appointment->status_id = $request->status_id;
            $appointment->activation_id = $request->activation_id;
            $appointment->value = $request->value;
            $appointment->date = $request->date;
            $appointment->save();
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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
