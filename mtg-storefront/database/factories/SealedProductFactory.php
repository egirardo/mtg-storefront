<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SealedProduct>
 */
class SealedProductFactory extends ProductFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => \App\Models\Product::factory()->state(['category_id' => 2]),
            'set_name' => fake()->randomElement([
                'Limited Edition Alpha',
                'Limited Edition Beta',
                'Unlimited Edition',
                'Revised Edition',
                'Fourth Edition',
                'Fifth Edition',
                'Classic Sixth Edition',
                'Seventh Edition',
                'Eighth Edition',
                'Ninth Edition',
                'Tenth Edition',
                'Magic 2010',
                'Magic 2011',
                'Magic 2012',
                'Magic 2013',
                'Magic 2014',
                'Magic 2015',
                'Magic Origins',
                'Core Set 2019',
                'Core Set 2020',
                'Core Set 2021',
                'Magic: The Gathering Foundations'
            ])
        ];
    }
}
