<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if stock_quantity column exists, if not add it
        if (!Schema::hasColumn('products', 'stock_quantity')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('stock_quantity')->default(0)->after('contract_price');
            });
        } else {
            // Column exists, just ensure it has default value
            DB::statement('UPDATE products SET stock_quantity = 0 WHERE stock_quantity IS NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop the column in down migration to preserve data
        // Schema::table('products', function (Blueprint $table) {
        //     $table->dropColumn('stock_quantity');
        // });
    }
};
