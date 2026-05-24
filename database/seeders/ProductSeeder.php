<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1, // Electronics
                'unit_id' => 1, // PCS
                'product_name' => 'Arduino Uno R3',
                'product_code' => 'ELEC-ARD-001',
                'description' => 'Microcontroller board based on ATmega328P',
                'stock_quantity' => 50,
                'status' => true,
            ],
            [
                'category_id' => 1, // Electronics
                'unit_id' => 1, // PCS
                'product_name' => 'Raspberry Pi 4 Model B',
                'product_code' => 'ELEC-RPI-001',
                'description' => 'Single-board computer with 4GB RAM',
                'stock_quantity' => 30,
                'status' => true,
            ],
            [
                'category_id' => 3, // Computer Accessories
                'unit_id' => 1, // PCS
                'product_name' => 'USB Flash Drive 32GB',
                'product_code' => 'COMP-USB-001',
                'description' => 'High-speed USB 3.0 flash drive',
                'stock_quantity' => 100,
                'status' => true,
            ],
            [
                'category_id' => 3, // Computer Accessories
                'unit_id' => 1, // PCS
                'product_name' => 'Wireless Mouse',
                'product_code' => 'COMP-MOU-001',
                'description' => 'Ergonomic wireless optical mouse',
                'stock_quantity' => 75,
                'status' => true,
            ],
            [
                'category_id' => 4, // Laboratory Equipment
                'unit_id' => 1, // PCS
                'product_name' => 'Digital Multimeter',
                'product_code' => 'LAB-DMM-001',
                'description' => 'Professional digital multimeter with auto-ranging',
                'stock_quantity' => 25,
                'status' => true,
            ],
            [
                'category_id' => 4, // Laboratory Equipment
                'unit_id' => 5, // SET
                'product_name' => 'Beaker Set',
                'product_code' => 'LAB-BKR-001',
                'description' => 'Glass beaker set (50ml, 100ml, 250ml, 500ml)',
                'stock_quantity' => 40,
                'status' => true,
            ],
            [
                'category_id' => 5, // Chemicals
                'unit_id' => 4, // LTR
                'product_name' => 'Distilled Water',
                'product_code' => 'CHEM-H2O-001',
                'description' => 'Laboratory grade distilled water',
                'stock_quantity' => 200,
                'status' => true,
            ],
            [
                'category_id' => 5, // Chemicals
                'unit_id' => 3, // KG
                'product_name' => 'Sodium Chloride',
                'product_code' => 'CHEM-NAC-001',
                'description' => 'Pure sodium chloride (NaCl) for laboratory use',
                'stock_quantity' => 50,
                'status' => true,
            ],
            [
                'category_id' => 6, // Safety Equipment
                'unit_id' => 1, // PCS
                'product_name' => 'Safety Goggles',
                'product_code' => 'SAFE-GOG-001',
                'description' => 'Chemical splash safety goggles',
                'stock_quantity' => 150,
                'status' => true,
            ],
            [
                'category_id' => 6, // Safety Equipment
                'unit_id' => 2, // BOX
                'product_name' => 'Latex Gloves',
                'product_code' => 'SAFE-GLV-001',
                'description' => 'Disposable latex gloves (100 pcs per box)',
                'stock_quantity' => 80,
                'status' => true,
            ],
            [
                'category_id' => 2, // Mechanical
                'unit_id' => 5, // SET
                'product_name' => 'Screwdriver Set',
                'product_code' => 'MECH-SCR-001',
                'description' => 'Professional screwdriver set with 12 pieces',
                'stock_quantity' => 35,
                'status' => true,
            ],
            [
                'category_id' => 2, // Mechanical
                'unit_id' => 1, // PCS
                'product_name' => 'Digital Caliper',
                'product_code' => 'MECH-CAL-001',
                'description' => 'Digital vernier caliper 0-150mm',
                'stock_quantity' => 20,
                'status' => true,
            ],
            [
                'category_id' => 1, // Electronics
                'unit_id' => 6, // PACK
                'product_name' => 'Resistor Kit',
                'product_code' => 'ELEC-RES-001',
                'description' => 'Assorted resistor kit (500 pieces)',
                'stock_quantity' => 60,
                'status' => true,
            ],
            [
                'category_id' => 4, // Laboratory Equipment
                'unit_id' => 1, // PCS
                'product_name' => 'Hot Plate Stirrer',
                'product_code' => 'LAB-HPS-001',
                'description' => 'Magnetic hot plate stirrer with digital display',
                'stock_quantity' => 15,
                'status' => true,
            ],
            [
                'category_id' => 3, // Computer Accessories
                'unit_id' => 1, // PCS
                'product_name' => 'HDMI Cable 2m',
                'product_code' => 'COMP-HDM-001',
                'description' => 'High-speed HDMI cable 2 meters',
                'stock_quantity' => 90,
                'status' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
