<?php

namespace Database\Seeders;

use App\Models\ServiceAndMedicine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceAndMedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servicesAndMedicines = [
            [
                'name' => 'Paracetamol',
                'category' => 'obat-obatan',
                'price' => 10000,
                'quantity' => 100,
            ],
            [
                'name' => 'Stetoskop',
                'category' => 'alat kesehatan',
                'price' => 150000,
                'quantity' => 20,
            ],
            [
                'name' => 'Konsultasi Dokter Umum',
                'category' => 'konsultasi doctor',
                'price' => 50000,
                'quantity' => null, // quantity bisa null untuk konsultasi dokter
            ],
        ];
        foreach ($servicesAndMedicines as $serviceAndMedicine) {
            ServiceAndMedicine::create($serviceAndMedicine);
        }
    }
}
