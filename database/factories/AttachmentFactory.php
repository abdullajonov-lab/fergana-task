<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attachment>
 */
class AttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "attachmentable_type"=>get_class(new Announcement()),
            "attachmentable_id"=>Announcement::factory()->create()->id,
            "path"=>$this->faker->imageUrl(),
        ];
    }
}
