<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecords;
use Illuminate\Http\Request;

class MedicalRecordsController extends Controller
{
    public function index(Request $request)
    {
        $medicalRecords = MedicalRecords::with('doctor', 'patient', 'serviceAndMedicine', 'patientSchedule')
            ->when($request->input('name'), function ($query, $name) {
                return $query->whereHas('patient', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'data' => $medicalRecords,
            'message' => 'Rekam medis berhasil diambil',
            'status' => 'Ok'
        ], 200);
    }


    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'patient_schedule_id' => 'required|exists:patient_schedules,id',
            'services' => 'required|array',
            'services.*' => 'exists:service_and_medicines,id',
            'status' => 'required|string',
            'diagnosis' => 'required|string',
            'medical_treatments' => 'required|string',
            'doctor_notes' => 'required|string',
        ]);

        $medicalRecord = MedicalRecords::create([
            'patient_id' => $request->input('patient_id'),
            'doctor_id' => $request->input('doctor_id'),
            'patient_schedule_id' => $request->input('patient_schedule_id'),
            'status' => $request->input('status'),
            'diagnosis' => $request->input('diagnosis'),
            'medical_treatments' => $request->input('medical_treatments'),
            'doctor_notes' => $request->input('doctor_notes'),
        ]);

        // Attach services
        $medicalRecord->serviceAndMedicine()->attach($request->input('services'));

        return response()->json([
            'message' => 'Medical record created successfully',
            'data' => $medicalRecord,
            'status' => 'Created'
        ], 201);
    }
}
