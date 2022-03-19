<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Announcement>
 */
class AnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'header' => $this->faker->title(),
            'subheader' => $this->faker->title(),
            'body' => $this->faker->text(),
            'image_path' => $this->faker->imageUrl()
        ];
    }
}
