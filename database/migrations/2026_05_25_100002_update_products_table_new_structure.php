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
        // Add new columns
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'sku')) {
                $table->string('sku')->nullable()->after('id');
            }
            if (!Schema::hasColumn('products', 'brand_id')) {
                $table->foreignId('brand_id')->nullable()->after('category_id')->constrained('brands')->nullOnDelete();
            }
            if (!Schema::hasColumn('products', 'regular_price')) {
                $table->decimal('regular_price', 10, 2)->nullable()->after('description');
            }
            if (!Schema::hasColumn('products', 'contract_price')) {
                $table->decimal('contract_price', 10, 2)->nullable()->after('regular_price');
            }
        });

        // Update existing products with default values
        DB::table('products')->whereNull('sku')->update([
            'sku' => DB::raw("'SKU-' || id"),
        ]);
        
        DB::table('products')->whereNull('regular_price')->update([
            'regular_price' => 0,
        ]);
        
        DB::table('products')->whereNull('contract_price')->update([
            'contract_price' => 0,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'brand_id')) {
                $table->dropForeign(['brand_id']);
                $table->dropColumn('brand_id');
            }
            if (Schema::hasColumn('products', 'sku')) {
                $table->dropColumn('sku');
            }
            if (Schema::hasColumn('products', 'regular_price')) {
                $table->dropColumn('regular_price');
            }
            if (Schema::hasColumn('products', 'contract_price')) {
                $table->dropColumn('contract_price');
            }
        });
    }
};
