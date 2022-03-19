<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Professor>
 */
class ProfessorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $employmentType = [
            'Full-time Employment',
            'Part-time Employment'
        ];

        return [
            'department_id' => Department::all()->random(1)->first()->id,
            'prefix' => $this->faker->jobTitle(),
            'employment_type' => $employmentType[random_int(0, 1)],
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'birthed_at' => $this->faker->date()
        ];
    }
}
