<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccessoryProduct>
 */
class AccessoryProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brand = fake()->randomElement([
            'Dragon Shield',
            'Ultra Pro',
            'Ultimate Guard',
            'Gamegenic',
            'BCW',
        ]);

        $type = fake()->randomElement([
            'Deck Box',
            'Card Sleeves',
            'Playmat',
            'Binder',
            'Toploader',
            'Card Storage Box',
        ]);

        return [
            'product_id' => \App\Models\Product::factory()->create([
                'category_id'  => 3,
                'product_name' => "{$brand} {$type}",
                'price'        => fake()->randomFloat(2, 5, 80),
                'stock'        => fake()->numberBetween(1, 100),
                'image'        => "https://placehold.co/400x400?text=" . urlencode("{$brand} {$type}"),,
            ])->product_id,
            'brand'        => $brand,
            'product_type' => $type,
        ];
    }
}
