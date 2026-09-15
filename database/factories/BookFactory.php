<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(50000, 500000),
            'quantity' => fake()->numberBetween(1, 100),
            'image' => 'book.jpg',
            'category_id' => fake()->numberBetween(1, 10),
        ];
    }
}
