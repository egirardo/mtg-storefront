<?php

namespace Database\Seeders;

use App\Models\SingleProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SingleProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SingleProduct::factory(10)->create();
    }
}
