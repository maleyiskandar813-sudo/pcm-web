<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Document>
 */
class DocumentFactory extends Factory
{
    protected $model = Document::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'category' => fake()->randomElement(Document::CATEGORIES),
            'file_path' => 'documents/'.fake()->uuid().'.pdf',
            'file_name' => fake()->slug(3).'.pdf',
            'file_size' => fake()->numberBetween(1024, 5000000),
            'uploaded_by' => User::factory(),
        ];
    }
}
