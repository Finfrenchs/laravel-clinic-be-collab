<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_name',
        'doctor_specialist',
        'doctor_phone',
        'doctor_email',
        'photo',
        'address',
        'sip',
        'id_ihs',
        'nik'
    ];

    public function schedule()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function patientSchedule()
    {
        return $this->hasMany(PatientSchedule::class);
    }

    public function serviceAndMedicine()
    {
        return $this->hasMany(ServiceAndMedicine::class);
    }


}
