<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentsTableSeeder extends Seeder
{
    public function run(): void
    {
        Student::create([
            'name' => 'Aqilah',
            'email' => 'aqilah@gmail.com',
            'password' => bcrypt('123456'),
            'program' => 'Software Engineering',
            'cgpa' => 3.00
        ]);
    }
}
