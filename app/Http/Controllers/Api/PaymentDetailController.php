<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentDetail;
use Illuminate\Http\Request;

class PaymentDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $completedPayments = PaymentDetail::with(['patientSchedule', 'patient'])
            ->when($request->input('name'), function ($query, $name) {
                return $query->whereHas('patient', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'data' => $completedPayments,
            'message' => 'Detail pembayaran berhasil diambil',
            'status' => 'Ok'
        ],);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'patient_schedule_id' => 'required|exists:patient_schedules,id',
            'patient_id' => 'required|exists:patients,id',
            'transaction_time' => 'required|date',
        ]);

        // Create new PaymentDetail instance
        $paymentDetail = PaymentDetail::create($validatedData);

        // Return success response
        return response()->json([
            'data' => $paymentDetail,
            'message' => 'Detail pembayaran berhasil disimpan',
            'status' => 'Ok'
        ], 201);
    }


}
