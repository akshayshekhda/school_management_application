<?php

namespace Database\Seeders;

use App\Models\ParentModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ParentSeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 5) as $index) {
            ParentModel::create([
                'name' => "Parent $index",
                'email' => "parent$index@school.com",
                'password' => Hash::make('password'),
                'phone' => "987654321$index",
                'student_id' => $index,
            ]);
        }
    }
}