<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecords extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'patient_schedule_id',
        'status',
        'diagnosis',
        'medical_treatments',
        'doctor_notes'
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patientSchedule()
    {
        return $this->belongsTo(PatientSchedule::class);
    }

    public function serviceAndMedicine()
    {
        return $this->belongsToMany(ServiceAndMedicine::class, 'medical_record_service', 'medical_record_id', 'service_and_medicine_id');
    }
}
