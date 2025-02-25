<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
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
    public function definition(): array
    {
        return [
            "title" => $this->faker->name,
            "slug" => $this->faker->slug,
            "user_id" => User::factory()->create()->id,
            "category_id" => Category::factory()->create()->id,
            "location" => $this->faker->text,
            "price" => $this->faker->numberBetween(100, 1000),
            "description" => $this->faker->paragraph(20),
        ];
    }
}
