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
        return [
            'product_id' => \App\Models\Product::factory()->state(['category_id' => 3]),
            'product_type' => fake()->randomElement([
                'Deck Box',
                'Card Sleeves',
                'Playmat',
                'Binder',
                'Portfolio',
                'Card Storage Box',
                'Life Counter',
                'Dice Set',
                'Spindown Die',
                'Token Cards',
                'Card Dividers',
                'Booster Box Case',
                'Collector Album',
                'Toploader',
                'Team Bag',
                'Playmat Tube',
                'Deck Case',
                'Card Sorting Tray',
                'Display Frame',
                'Carrying Case'
            ])
        ];
    }
}
