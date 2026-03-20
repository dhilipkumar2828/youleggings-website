<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * color_images stores mapping: #hexColor=imagePath;#hexColor2=imagePath2 ...
     * This allows each color in a variant to have its own specific image assigned.
     */
    public function up(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            if (!Schema::hasColumn('product_variants', 'color_images')) {
                $table->text('color_images')->nullable()->after('colors');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            if (Schema::hasColumn('product_variants', 'color_images')) {
                $table->dropColumn('color_images');
            }
        });
    }
};
