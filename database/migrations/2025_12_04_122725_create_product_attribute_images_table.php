<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attribute_images', function (Blueprint $table) {
            $table->id();

            // Foreign key: products table
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');

            // Foreign key: products_attributes table
            $table->unsignedBigInteger('product_attributes_id');
            $table->foreign('product_attributes_id')
                ->references('id')->on('product_attributes')
                ->onDelete('cascade');

            $table->string('image_url')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attribute_images');
    }
};
