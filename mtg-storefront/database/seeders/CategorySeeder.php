<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category_id' => 1, 'category_name' => 'Singles'],
            ['category_id' => 2, 'category_name' => 'Sealed'],
            ['category_id' => 3, 'category_name' => 'Accessories'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['category_id' => $category['category_id']],
                $category
            );
        }
    }
}
