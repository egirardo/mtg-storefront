<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SingleProduct>
 */
class SingleProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => \App\Models\Product::factory()->state(['category_id' => 1]),
            'rarity' => fake()->randomElement(['Common', 'Uncommon', 'Rare', 'Mythic']),
            'color' => fake()->randomElement(['Blue', 'Red', 'Green', 'Black', 'Colorless', 'White']),
            'number' => fake()->numberBetween(0, 500),
            'set_name_single' => fake()->randomElement([
                'MH3',
                'MH2',
                'FDN',
                'BLB',
                'MKM',
            ])
        ];
    }
}
