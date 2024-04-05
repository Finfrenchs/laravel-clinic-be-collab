<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\PatientSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PatientScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $schedules = PatientSchedule::with('doctor', 'patient')
            ->when($request->input('nik'), function ($query, $nik) {
                return $query->whereHas('patient', function ($query) use ($nik) {
                    $query->where('nik', 'like', '%' . $nik . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        // Mengembalikan daftar jadwal dalam format JSON
        return response()->json([
            'data' => $schedules,
            'message' => 'Daftar jadwal patient berhasil diambil',
            'status' => 'success'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'schedule_time' => 'required|string',
            'complaint' => 'required|string',
            'doctor_id' => 'required|exists:doctors,id',
            'status' => 'nullable|string',
        ]);

        // Dapatkan data pasien dan dokter yang sesuai dengan ID yang diberikan
        $patient = Patient::findOrFail($request->patient_id);
        $doctor = Doctor::findOrFail($request->doctor_id);

        // Reset nomor antrian jika sudah melewati tanggal schedule_time
        $scheduleTime = Carbon::parse($request->schedule_time);
        if ($scheduleTime->isPast()) {
            PatientSchedule::whereDate('schedule_time', $scheduleTime->toDateString())->update(['no_antrian' => 0]);
        }

        // Ambil nomor antrian berikutnya untuk schedule time yang sama
        $nextNoAntrian = PatientSchedule::whereDate('schedule_time', $scheduleTime->toDateString())->max('no_antrian') + 1;

        // Tentukan nilai default untuk payment_method dan total_price
    $paymentMethod = $request->payment_method ?? 'Tunai';
    $totalPrice = $request->total_price ?? 0;


        $patientSchedule = PatientSchedule::create([
            'patient_id' => $patient->id,
            'schedule_time' => $request->schedule_time,
            'complaint' => $request->complaint,
            'doctor_id' => $doctor->id,
            'status' => $request->status ?? 'waiting',
            'no_antrian' => $nextNoAntrian,
            'payment_method' => $paymentMethod,
            'total_price' => $totalPrice,
        ]);

        // Mengembalikan respons JSON
        return response()->json([
            'data' => $patientSchedule,
            'message' => 'Patient schedule created successfully',
            'status' => 'Created'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
