<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PatientSchedule>
 */
class PatientScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => function () {
                return \App\Models\Patient::factory()->create()->id;
            },
            'doctor_id' => function () {
                return \App\Models\Doctor::factory()->create()->id;
            },
            'schedule_time' => $this->faker->dateTimeBetween('now', '+1 year'),
            'complaint' => $this->faker->sentence,
            'status' => 'waiting',
            'no_antrian' => $this->faker->numberBetween(1, 100),
            'payment_method' => $this->faker->randomElement(['Tunai', 'QRIS']),
            'total_price' => $this->faker->numberBetween(10000, 1000000),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
