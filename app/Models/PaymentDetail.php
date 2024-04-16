<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_schedule_id',
        'patient_id',
        'transaction_time',

    ];

    public function patientSchedule()
    {
        return $this->belongsTo(PatientSchedule::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
