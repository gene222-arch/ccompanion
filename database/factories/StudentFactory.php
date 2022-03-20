<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $id = Student::all()->last()->id + 1;

        return [
            'student_id' => Carbon::now()->format('Y') . "-{$id}",
            'course_id' => Course::all()->random(1)->first()->id,
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'guardian' => $this->faker->name(),
            'contact_number' => $this->faker->phoneNumber(),
            'birthed_at' => $this->faker->date()
        ];
    }
}
