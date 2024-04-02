<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mengambil semua data jadwal dokter
        $schedules = DoctorSchedule::with('doctor')
            ->when($request->input('name'), function ($query, $doctor_name) {
                return $query->whereHas('doctor', function ($query) use ($doctor_name) {
                    $query->where('doctor_name', 'like', '%' . $doctor_name . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        // Mengembalikan daftar jadwal dalam format JSON
        return response()->json([
            'data' => $schedules,
            'message' => 'Daftar jadwal dokter berhasil diambil',
            'status' => 'success'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Mengambil data jadwal dokter berdasarkan ID
        $schedule = DoctorSchedule::find($id);

        // Jika jadwal tidak ditemukan
        if (!$schedule) {
            return response()->json([
                'message' => 'Jadwal tidak ditemukan',
                'status' => 'error'
            ], 404);
        }

        // Mengembalikan data jadwal dalam format JSON
        return response()->json([
            'data' => $schedule,
            'message' => 'Jadwal berhasil ditemukan',
            'status' => 'success'
        ], 200);
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
