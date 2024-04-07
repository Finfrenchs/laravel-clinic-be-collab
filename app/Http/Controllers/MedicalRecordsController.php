<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecords;
use Illuminate\Http\Request;

class MedicalRecordsController extends Controller
{
    //index
    public function index(Request $request)
    {
        $medicalRecords = MedicalRecords::with('doctor', 'patient', 'serviceAndMedicine', 'patientSchedule')
            ->when($request->input('name'), function ($query, $name) {
                return $query->whereHas('patient', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                });
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('pages.medical_records.index', compact('medicalRecords'));
    }
}
