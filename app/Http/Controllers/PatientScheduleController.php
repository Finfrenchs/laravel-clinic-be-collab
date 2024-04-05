<?php

namespace App\Http\Controllers;

use App\Models\PatientSchedule;
use Illuminate\Http\Request;

class PatientScheduleController extends Controller
{
    //index
    public function index(Request $request)
    {
        $query = PatientSchedule::query()
        ->with('doctor', 'patient')
        ->when($request->patient_id, function ($query, $patient_id) {
            $query->where('patient_id', $patient_id);
        })
        ->orderBy('patient_id', 'asc');

    $patientSchedules = $query->paginate(10);

    return view('pages.patient_schedules.index', compact('patientSchedules'));
    }
}
