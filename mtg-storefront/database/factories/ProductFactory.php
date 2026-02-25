<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4d/Cat_November_2010-1a.jpg/960px-Cat_November_2010-1a.jpg',
            'product_name' => ucwords(fake()->words(2, true)),
            'category_id' => fake()->numberBetween(1, 3),
            'price' => fake()->randomFloat(2, 1, 500),
            'stock' => fake()->numberBetween(1, 100)
        ];
    }
}
