<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $courses = [
            'Information Technology',
            'Computer Science',
            'Accounting',
            'Secondary Education Major in English',
            'Secondary Education Major in Math',
            'Secondary Education Major in Science',
            'Elementary Education Major in English',
            'Elementary Education Major in Math',
            'Elementary Education Major in Science'
        ];

        return [
            'name' => $courses[random_int(0, 8)]
        ];
    }
}
