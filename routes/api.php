<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\DoctorScheduleController;
use App\Http\Controllers\Api\MedicalRecordsController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\PatientScheduleController;
use App\Http\Controllers\Api\ServiceAndMedicineController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//login
Route::post('/login', [AuthController::class, 'login']);

//logout
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

//doctors
Route::apiResource('/api-doctors', DoctorController::class)->middleware('auth:sanctum');

//patients
Route::apiResource('/api-patients', PatientController::class)->middleware('auth:sanctum');

//doctor schedules
Route::apiResource('/api-doctor-schedules', DoctorScheduleController::class)->middleware('auth:sanctum');

//patient schedules
Route::apiResource('/api-patient-schedules', PatientScheduleController::class)->middleware('auth:sanctum');

//Service and Medicine
Route::apiResource('/api-service-medicines', ServiceAndMedicineController::class)->middleware('auth:sanctum');

//Medical Records
Route::apiResource('/api-medical-records', MedicalRecordsController::class)->middleware('auth:sanctum');
Route::get('/api-medical-records/services/{scheduleId}', [MedicalRecordsController::class, 'getServicesByScheduleId'])->middleware('auth:sanctum');
