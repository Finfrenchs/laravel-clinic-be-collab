<?php

use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Controllers\PatientScheduleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('home', function () {
        return view('dashboard');
    })->name('home');

    Route::resource('users', UserController::class);
    //doctors
    Route::resource('doctors', DoctorController::class);
    //doctor-schedules
    Route::resource('doctor-schedules', DoctorScheduleController::class);
    //patient-schedules
    Route::resource('patient-schedules', PatientScheduleController::class);
    //patients
    Route::resource('patients', \App\Http\Controllers\PatientController::class);
    //services_and_medicines
    Route::resource('services_and_medicines', \App\Http\Controllers\ServiceAndMedicineController::class);
    //medical_records
    Route::resource('medical-records', \App\Http\Controllers\MedicalRecordsController::class);

});
