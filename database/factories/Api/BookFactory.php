<?php

namespace Database\Factories\Api;

use App\Models\Api\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'description' => fake()->text(),
            'image_path' => fake()->imageUrl(),
            'page_count' => fake()->randomNumber(),
        ];
    }
}
