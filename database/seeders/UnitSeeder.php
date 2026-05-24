<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'unit_name' => 'Pieces',
                'short_name' => 'PCS',
                'description' => 'Individual pieces or units',
                'status' => true,
            ],
            [
                'unit_name' => 'Box',
                'short_name' => 'BOX',
                'description' => 'Boxed items',
                'status' => true,
            ],
            [
                'unit_name' => 'Kilogram',
                'short_name' => 'KG',
                'description' => 'Weight in kilograms',
                'status' => true,
            ],
            [
                'unit_name' => 'Liter',
                'short_name' => 'LTR',
                'description' => 'Volume in liters',
                'status' => true,
            ],
            [
                'unit_name' => 'Set',
                'short_name' => 'SET',
                'description' => 'Complete set of items',
                'status' => true,
            ],
            [
                'unit_name' => 'Pack',
                'short_name' => 'PACK',
                'description' => 'Packaged items',
                'status' => true,
            ],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
