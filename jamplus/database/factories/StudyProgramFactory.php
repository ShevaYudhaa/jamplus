<?php

namespace Database\Factories;

use App\Models\StudyProgram;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<StudyProgram> */
class StudyProgramFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->bothify('T########'),
            'name' => 'Program Studi Pengujian',
        ];
    }
}
