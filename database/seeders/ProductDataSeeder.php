<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;

class ProductDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get brand IDs
        $arduino = Brand::where('brand_name', 'Arduino')->first();
        $raspberryPi = Brand::where('brand_name', 'Raspberry Pi')->first();
        $sandisk = Brand::where('brand_name', 'SanDisk')->first();
        $logitech = Brand::where('brand_name', 'Logitech')->first();
        $hp = Brand::where('brand_name', 'HP')->first();
        $dell = Brand::where('brand_name', 'Dell')->first();
        $fluke = Brand::where('brand_name', 'Fluke')->first();
        $tektronix = Brand::where('brand_name', 'Tektronix')->first();
        $generic = Brand::where('brand_name', 'Generic')->first();

        // Update products with realistic data including stock quantities
        $updates = [
            'SKU-1' => [
                'brand_id' => $arduino?->id, 
                'regular_price' => 850.00, 
                'contract_price' => 750.00,
                'stock_quantity' => 150
            ],
            'SKU-2' => [
                'brand_id' => $raspberryPi?->id, 
                'regular_price' => 6500.00, 
                'contract_price' => 5900.00,
                'stock_quantity' => 50
            ],
            'SKU-3' => [
                'brand_id' => $sandisk?->id, 
                'regular_price' => 450.00, 
                'contract_price' => 390.00,
                'stock_quantity' => 300
            ],
            'SKU-4' => [
                'brand_id' => $logitech?->id, 
                'regular_price' => 700.00, 
                'contract_price' => 620.00,
                'stock_quantity' => 120
            ],
            'SKU-5' => [
                'brand_id' => $fluke?->id, 
                'regular_price' => 8500.00, 
                'contract_price' => 7800.00,
                'stock_quantity' => 25
            ],
            'SKU-6' => [
                'brand_id' => $hp?->id, 
                'regular_price' => 15500.00, 
                'contract_price' => 14200.00,
                'stock_quantity' => 30
            ],
            'SKU-7' => [
                'brand_id' => $dell?->id, 
                'regular_price' => 8900.00, 
                'contract_price' => 8100.00,
                'stock_quantity' => 45
            ],
            'SKU-8' => [
                'brand_id' => $fluke?->id, 
                'regular_price' => 3200.00, 
                'contract_price' => 2900.00,
                'stock_quantity' => 60
            ],
            'SKU-9' => [
                'brand_id' => $tektronix?->id, 
                'regular_price' => 12500.00, 
                'contract_price' => 11300.00,
                'stock_quantity' => 15
            ],
            'SKU-10' => [
                'brand_id' => $arduino?->id, 
                'regular_price' => 4500.00, 
                'contract_price' => 4100.00,
                'stock_quantity' => 80
            ],
            'SKU-11' => [
                'brand_id' => $generic?->id, 
                'regular_price' => 250.00, 
                'contract_price' => 220.00,
                'stock_quantity' => 200
            ],
            'SKU-12' => [
                'brand_id' => $generic?->id, 
                'regular_price' => 180.00, 
                'contract_price' => 160.00,
                'stock_quantity' => 250
            ],
        ];

        foreach ($updates as $sku => $data) {
            Product::where('sku', $sku)->update($data);
        }

        // Update all remaining products with generic brand and stock if they don't have data
        if ($generic) {
            Product::whereNull('brand_id')->update([
                'brand_id' => $generic->id,
                'regular_price' => DB::raw('CASE WHEN regular_price = 0 THEN 500.00 ELSE regular_price END'),
                'contract_price' => DB::raw('CASE WHEN contract_price = 0 THEN 450.00 ELSE contract_price END'),
                'stock_quantity' => 100,
            ]);
        }
        
        // Update products with zero stock to have default stock
        Product::where('stock_quantity', 0)->update([
            'stock_quantity' => 75,
        ]);
    }
}
