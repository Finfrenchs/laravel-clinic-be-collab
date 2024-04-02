<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceAndMedicine>
 */
class ServiceAndMedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['obat-obatan', 'alat kesehatan', 'konsultasi doctor'];

        return [
            'name' => $this->faker->word,
            'category' => $this->faker->randomElement($categories),
            'price' => $this->faker->numberBetween(10, 1000),
            'quantity' => $this->faker->randomNumber(2),
        ];
    }
}
