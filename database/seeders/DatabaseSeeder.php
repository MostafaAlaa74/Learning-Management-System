<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Database\Factories\CourseFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Course::factory(30)->create();
        Lesson::factory(100)->create();
        User::factory()->create([
            'name' => 'Mostafa Alaa',
            'email' => 'mostafa@gmail.com',
            'password' => 123456789,
            'role' => 'admin'
        ]);
    }
}
