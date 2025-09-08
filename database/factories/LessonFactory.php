<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'course_id' => \App\Models\Course::factory(), // Assuming you have a Course factory
            'video_URL' => $this->faker->url,
            'assignments_path' => $this->faker->url,
            'presentations_path' => $this->faker->url,
        ];
    }
}
