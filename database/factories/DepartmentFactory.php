<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $departments = [
            'Computer Department',
            'Business Department',
            'Education Department'
        ];

        return [
            'name' => $departments[random_int(0, 2)]
        ];
    }
}
