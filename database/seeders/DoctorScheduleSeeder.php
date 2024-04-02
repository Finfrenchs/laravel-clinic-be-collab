<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create doctor schedule
        \App\Models\DoctorSchedule::create([
            'doctor_id' => 1,
            'day' => 'Monday',
            'time' => '08:00 - 12:00'
        ]);

        //auto generate doctor schedule
        // \App\Models\Doctor::all()->each(function ($doctor) {
        //     \App\Models\DoctorSchedule::factory()->count(1)->create([
        //         'doctor_id' => $doctor->id
        //     ]);
        // });

        $doctors = Doctor::all();

        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // Looping melalui setiap dokter
        foreach ($doctors as $doctor) {
            // Looping melalui setiap hari dalam seminggu
            foreach ($daysOfWeek as $day) {
                $startTime = Carbon::createFromTime(8, 0, 0)->addHours(rand(0, 3));
                $endTime = $startTime->copy()->addHours(8);


                $note = "Catatan untuk dokter {$doctor->doctor_name} pada hari $day";


                DoctorSchedule::create([
                    'doctor_id' => $doctor->id,
                    'day' => $day,
                    'time' => $startTime->format('H:i') . ' - ' . $endTime->format('H:i'),
                    'note' => $note,
                ]);
            }
        }
    }
}
