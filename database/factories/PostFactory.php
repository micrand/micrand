<?php

namespace Database\Factories;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->paragraphs(5, true),
            'featured_image' => null,
            'status' => PostStatus::DRAFT,
            'published_at' => null,
            'meta_title' => $title,
            'meta_description' => fake()->text(155),
            'canonical_url' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (): array => [
            'status' => PostStatus::PUBLISHED,
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn (): array => [
            'status' => PostStatus::ARCHIVED,
            'published_at' => fake()->dateTimeBetween('-1 year', '-6 months'),
        ]);
    }
}