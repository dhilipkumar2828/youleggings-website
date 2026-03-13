<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            if (!Schema::hasColumn('product_variants', 'colors')) {
                $table->string('colors')->nullable()->after('in_stock');
            }
            if (!Schema::hasColumn('product_variants', 'sale_price')) {
                $table->decimal('sale_price', 12, 2)->nullable()->after('regular_price');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            if (Schema::hasColumn('product_variants', 'colors')) {
                $table->dropColumn('colors');
            }
            if (Schema::hasColumn('product_variants', 'sale_price')) {
                $table->dropColumn('sale_price');
            }
        });
    }
};
