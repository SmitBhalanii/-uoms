<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'category_name' => 'Electronics',
                'description' => 'Electronic components and devices',
                'status' => true,
            ],
            [
                'category_name' => 'Mechanical',
                'description' => 'Mechanical tools and equipment',
                'status' => true,
            ],
            [
                'category_name' => 'Computer Accessories',
                'description' => 'Computer hardware and accessories',
                'status' => true,
            ],
            [
                'category_name' => 'Laboratory Equipment',
                'description' => 'General laboratory equipment and tools',
                'status' => true,
            ],
            [
                'category_name' => 'Chemicals',
                'description' => 'Laboratory chemicals and reagents',
                'status' => true,
            ],
            [
                'category_name' => 'Safety Equipment',
                'description' => 'Safety gear and protective equipment',
                'status' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
