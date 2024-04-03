<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    //index
    public function index(Request $request)
    {
        //get all patients paginated
        //search patients by nik
        $patients = DB::table('patients')
            ->when($request->input('nik'), function ($query, $name) {
                return $query->where('nik', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc')
            ->get();

        return response([
            'data' => $patients,
            'message' => 'Success',
            'status' => 'OK'
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string',
            'kk' => 'required|string',
            'name' => 'required|string',
            'phone' => 'required|string',
            'gender' => 'required|string',
            'birth_place' => 'required|string',
            'birth_date' => 'required|string',
            'is_deceased' => 'int',
            'address_line' => 'required|string',
            'city' => 'string',
            'city_code' => 'string',
            'province' => 'string',
            'province_code' => 'string',
            'district' => 'string',
            'district_code' => 'string',
            'village' => 'string',
            'village_code' => 'string',
            'rt' => 'string',
            'rw' => 'string',
            'postal_code' => 'string',
            'marital_status' => 'string',
            'relationship_name' => 'nullable|string',
            'relationship_phone' => 'nullable|string',
        ]);

        $patient = Patient::create($request->all());

        return response([
            'data' => $patient,
            'message' => 'Patient created successfully',
            'status' => 'Created'
        ], 201);
    }
}
