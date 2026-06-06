<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['brand_name' => 'Arduino', 'description' => 'Open-source electronics platform', 'status' => true],
            ['brand_name' => 'Raspberry Pi', 'description' => 'Single-board computer manufacturer', 'status' => true],
            ['brand_name' => 'SanDisk', 'description' => 'Flash memory products', 'status' => true],
            ['brand_name' => 'Logitech', 'description' => 'Computer peripherals and software', 'status' => true],
            ['brand_name' => 'HP', 'description' => 'Information technology company', 'status' => true],
            ['brand_name' => 'Dell', 'description' => 'Computer technology company', 'status' => true],
            ['brand_name' => 'Canon', 'description' => 'Imaging and optical products', 'status' => true],
            ['brand_name' => 'Fluke', 'description' => 'Electronic test tools and software', 'status' => true],
            ['brand_name' => 'Tektronix', 'description' => 'Test and measurement equipment', 'status' => true],
            ['brand_name' => 'Generic', 'description' => 'Generic brand products', 'status' => true],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
