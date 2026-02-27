<?php

namespace Database\Seeders;

use App\Models\AccessoryProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccessoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AccessoryProduct::factory(10)->create();
    }
}
