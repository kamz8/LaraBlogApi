<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isScheduled = $this->faker->boolean(40); // 40% chance for scheduled post

        $scheduledAt = $isScheduled ? $this->faker->dateTimeBetween('now', '+10 day') : null;

        return [
            'category_id' => User::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'slug' => Str::slug($this->faker->unique()->sentence(), '-'),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
            'scheduled_at' => $scheduledAt,
            'thumbnail' => $this->faker->imageUrl(),
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
