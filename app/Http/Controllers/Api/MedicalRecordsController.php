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
            'services.*.id' => 'exists:service_and_medicines,id', // Validasi id layanan dalam array
            'services.*.quantity' => 'required|integer|min:1', // Validasi kuantitas yang diberikan
            'status' => 'required|string',
            'diagnosis' => 'required|string',
            'medical_treatments' => 'required|string',
            'doctor_notes' => 'required|string',
        ]);

        // Membuat rekam medis baru
        $medicalRecord = MedicalRecords::create([
            'patient_id' => $request->input('patient_id'),
            'doctor_id' => $request->input('doctor_id'),
            'patient_schedule_id' => $request->input('patient_schedule_id'),
            'status' => $request->input('status'),
            'diagnosis' => $request->input('diagnosis'),
            'medical_treatments' => $request->input('medical_treatments'),
            'doctor_notes' => $request->input('doctor_notes'),
        ]);

        // Melampirkan layanan dan obat ke rekam medis dengan menyimpan kuantitas
        foreach ($request->input('services') as $service) {
            $medicalRecord->serviceAndMedicine()->attach($service['id'], ['quantity' => $service['quantity']]);
        }

        // Mendapatkan kembali rekam medis dengan data terkini (termasuk kuantitas)
        $medicalRecord = MedicalRecords::with('doctor', 'patient', 'serviceAndMedicine', 'patientSchedule')
            ->find($medicalRecord->id);

        return response()->json([
            'message' => 'Medical record created successfully',
            'data' => $medicalRecord,
            'status' => 'Created'
        ], 201);
    }



    public function getServicesByScheduleId($scheduleId)
    {
        // Cari catatan medis berdasarkan patient_schedule_id
        $medicalRecords = MedicalRecords::where('patient_schedule_id', $scheduleId)->get();

        // Inisialisasi array untuk menyimpan hasil
        $services = [];

        // Loop melalui setiap catatan medis
        foreach ($medicalRecords as $medicalRecord) {
            // Ambil layanan yang terkait dengan catatan medis
            $medicalServices = $medicalRecord->serviceAndMedicine()->withPivot('quantity')->get();

            // Loop melalui setiap layanan yang terkait
            foreach ($medicalServices as $service) {
                // Tambahkan layanan dan kuantitasnya ke dalam array
                $services[] = [
                    'service_name' => $service->name,
                    'quantity' => $service->pivot->quantity,
                    'price' => $service->price
                ];
            }
        }

        return response()->json([
            'message' => 'List layanan yang di pilih berhasil di ambil',
            'status' => 'Ok',
            'data' => $services
        ], 200);
    }




    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'patient_id' => 'required|exists:patients,id',
    //         'doctor_id' => 'required|exists:doctors,id',
    //         'patient_schedule_id' => 'required|exists:patient_schedules,id',
    //         'services' => 'required|array',
    //         'services.*' => 'exists:service_and_medicines,id',
    //         'status' => 'required|string',
    //         'diagnosis' => 'required|string',
    //         'medical_treatments' => 'required|string',
    //         'doctor_notes' => 'required|string',
    //     ]);

    //     $medicalRecord = MedicalRecords::create([
    //         'patient_id' => $request->input('patient_id'),
    //         'doctor_id' => $request->input('doctor_id'),
    //         'patient_schedule_id' => $request->input('patient_schedule_id'),
    //         'status' => $request->input('status'),
    //         'diagnosis' => $request->input('diagnosis'),
    //         'medical_treatments' => $request->input('medical_treatments'),
    //         'doctor_notes' => $request->input('doctor_notes'),
    //     ]);

    //     // Attach services
    //     $medicalRecord->serviceAndMedicine()->attach($request->input('services'));

    //     return response()->json([
    //         'message' => 'Medical record created successfully',
    //         'data' => $medicalRecord,
    //         'status' => 'Created'
    //     ], 201);
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'patient_id' => 'required|exists:patients,id',
    //         'doctor_id' => 'required|exists:doctors,id',
    //         'patient_schedule_id' => 'required|exists:patient_schedules,id',
    //         'services' => 'required|array',
    //         'services.*.id' => 'required|exists:service_and_medicines,id',
    //         'services.*.quantity' => 'required|integer|min:1',
    //         'status' => 'required|string',
    //         'diagnosis' => 'required|string',
    //         'medical_treatments' => 'required|string',
    //         'doctor_notes' => 'required|string',
    //         'services.*.name' => 'required|string', // Tambahkan validasi untuk nama layanan
    //         'services.*.category' => 'required|string', // Tambahkan validasi untuk kategori layanan
    //         'services.*.price' => 'required|numeric|min:0', // Tambahkan validasi untuk harga layanan
    //     ]);

    //     $medicalRecord = MedicalRecords::create([
    //         'patient_id' => $request->input('patient_id'),
    //         'doctor_id' => $request->input('doctor_id'),
    //         'patient_schedule_id' => $request->input('patient_schedule_id'),
    //         'status' => $request->input('status'),
    //         'diagnosis' => $request->input('diagnosis'),
    //         'medical_treatments' => $request->input('medical_treatments'),
    //         'doctor_notes' => $request->input('doctor_notes'),
    //     ]);

    //     // Attach services
    //     foreach ($request->input('services') as $service) {
    //         $medicalRecord->serviceAndMedicine()->attach($service['id'], [
    //             'quantity' => $service['quantity'],
    //             'name' => $service['name'],
    //             'category' => $service['category'],
    //             'price' => $service['price'],
    //         ]);
    //     }
    //     return response()->json([
    //         'message' => 'Medical record created successfully',
    //         'data' => $medicalRecord,
    //         'status' => 'Created'
    //     ], 201);
    // }
}
