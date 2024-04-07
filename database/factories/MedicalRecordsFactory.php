<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalRecords>
 */
class MedicalRecordsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => \App\Models\Patient::factory(),
            'doctor_id' => \App\Models\Doctor::factory(),
            'patient_schedule_id' => \App\Models\PatientSchedule::factory(),
            'status' => $this->faker->randomElement(['Dewasa', 'Anak - anak']),
            'diagnosis' => $this->faker->sentence,
            'medical_treatments' => $this->faker->paragraph,
            'doctor_notes' => $this->faker->paragraph,
        ];
    }
}
