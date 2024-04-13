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
        // Temukan jadwal pasien yang akan diupdate
        $patientSchedule = PatientSchedule::findOrFail($id);

        // Validasi request
        $request->validate([
            'patient_id' => 'exists:patients,id',
            'schedule_time' => 'string',
            'complaint' => 'string',
            'doctor_id' => 'exists:doctors,id',
            'status' => 'string',
            'payment_method' => 'string',
            'total_price' => 'integer',
            'no_antrian' => 'integer',
        ]);

        // Ubah data jika ada dalam request
        if ($request->filled('patient_id')) {
            $patientSchedule->patient_id = $request->patient_id;
        }
        if ($request->filled('schedule_time')) {
            $patientSchedule->schedule_time = $request->schedule_time;
        }
        if ($request->filled('complaint')) {
            $patientSchedule->complaint = $request->complaint;
        }
        if ($request->filled('doctor_id')) {
            $patientSchedule->doctor_id = $request->doctor_id;
        }
        if ($request->filled('status')) {
            $patientSchedule->status = $request->status;
        }
        if ($request->filled('payment_method')) {
            $patientSchedule->payment_method = $request->payment_method;
        }
        if ($request->filled('total_price')) {
            $patientSchedule->total_price = $request->total_price;
        }
        if ($request->filled('no_antrian')) {
            $patientSchedule->no_antrian = $request->no_antrian;
        }

        // Simpan perubahan
        $patientSchedule->save();

        // Mengembalikan respons JSON
        return response()->json([
            'data' => $patientSchedule,
            'message' => 'Patient schedule updated successfully',
            'status' => 'Updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
