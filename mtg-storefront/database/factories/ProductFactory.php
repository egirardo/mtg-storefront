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
        $brand = fake()->randomElement(['Dragon Shield', 'Ultra Pro', 'Ultimate Guard', 'BCW', 'Gamegenic']);
        $type  = fake()->randomElement(['Deck Box', 'Card Sleeves', 'Playmat', 'Binder', 'Toploader']);

        return [
            'product_name' => "{$brand} {$type}",
            'price'        => fake()->randomFloat(2, 5, 80),
            'stock'        => fake()->numberBetween(1, 100),
            'image'        => null,
        ];
    }
}
