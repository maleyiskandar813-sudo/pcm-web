<?php

namespace Database\Factories;

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
        return [
            'category_id' => Category::factory(),
            'author_id' => User::factory(),
            'title' => $this->faker->sentence(6),
            'slug' => fn (array $attr) => Str::slug($attr['title']).'-'.Str::lower(Str::random(4)),
            'excerpt' => $this->faker->paragraph(2),
            'body' => $this->faker->paragraphs(4, true),
            'cover_image' => null,
            'status' => Post::STATUS_PUBLISHED,
            'needs_approval' => false,
            'is_approved' => false,
            'approved_at' => null,
            'published_at' => now(),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => Post::STATUS_DRAFT,
            'published_at' => null,
        ]);
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => Post::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);
    }

    public function needsApproval(): static
    {
        return $this->state(fn () => ['needs_approval' => true]);
    }

    public function approved(): static
    {
        return $this->state(fn () => [
            'is_approved' => true,
            'approved_at' => now(),
        ]);
    }

    public function scheduled(?\DateTimeInterface $at = null): static
    {
        return $this->state(fn () => ['published_at' => $at ?? now()->addDay()]);
    }
}
