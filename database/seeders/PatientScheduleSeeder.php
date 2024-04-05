<?php

namespace Database\Seeders;

use App\Models\PatientSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PatientSchedule::factory(30)->create();
    }
}
