<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $classes = ['Class 1', 'Class 2', 'Class 3', 'Class 4', 'Class 5'];
        
        foreach (range(1, 10) as $index) {
            Student::create([
                'name' => "Student $index",
                'email' => "student$index@school.com",
                'password' => Hash::make('password'),
                'roll_number' => "S" . str_pad($index, 3, '0', STR_PAD_LEFT),
                'class' => $classes[array_rand($classes)],
                'address' => "Address $index",
                'phone' => "123456789$index",
            ]);
        }
    }
}
