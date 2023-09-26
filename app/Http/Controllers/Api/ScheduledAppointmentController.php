<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ScheduledAppointment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduledAppointmentController extends Controller
{
    public function list()
    {
        $scheduledAppointments = DB::table('scheduled_appointments')
            ->leftJoin('appointments', 'scheduled_appointments.appointment_id', '=', 'appointments.id')
            ->select('scheduled_appointments.*', 'appointments.activation_id')
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $scheduledAppointments], 200);
    }

    public function show(string $id)
    {
        $scheduledAppointment = DB::table('scheduled_appointments')
            ->leftJoin('appointments', 'scheduled_appointments.appointment_id', '=', 'appointments.id')
            ->select('scheduled_appointments.*', 'appointments.activation_id')
            ->where([['scheduled_appointments.id', '=', $id]])
            ->get();

        return response()->json(['success' => true, 'message' => "", "dados" => $scheduledAppointment], !empty($scheduledAppointment) ? 200 : 404);
    }

    public function store(Request $request)
    {
        try {
            $scheduledAppointment = new ScheduledAppointment();
            $scheduledAppointment->scheduled_date = $request->scheduled_date;
            $scheduledAppointment->appointment_id = $request->appointment_id;
            $scheduledAppointment->end_date = $request->end_date;
            $scheduledAppointment->save();
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $dados = $request->except('id');
            $scheduledAppointment = ScheduledAppointment::find($request->id);
            $scheduledAppointment->update($dados);
            return response()->json(['success' => true, 'message' => ''], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $scheduledAppointment = ScheduledAppointment::find($request->id);
            if (isset($scheduledAppointment)) {
                $scheduledAppointment->delete();
            }
            return response()->json(['success' => true, 'message' => ""], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getByAppointment(int $id)
    {
        $scheduledAppointment = $this->getBy('scheduled_appointments', 'appointment_id', $id);
        return response()->json(['success' => true, 'message' => "", "dados" => $scheduledAppointment], count($scheduledAppointment) >= 1 ? 200 : 404);
    }

    public function getBy(string $table, string $field, $value)
    {
        $scheduledAppointment =  DB::table('scheduled_appointments')
        ->leftJoin('appointments', 'scheduled_appointments.appointment_id', '=', 'appointments.id')
        ->select('scheduled_appointments.*', 'appointments.activation_id')
        ->where([[$table.'.'.$field, '=', $value]])
        ->get();

        return $scheduledAppointment;
    }
}
