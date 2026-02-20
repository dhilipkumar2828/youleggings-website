<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlashDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flash_deals', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // Left Banner Title: FASHION MODEL
            $table->string('subtitle')->nullable(); // Left Banner Subtitle: THIS WINTER
            $table->text('description')->nullable(); // description text
            $table->string('button_text')->default('See Collection');
            $table->string('collection_link')->nullable(); 
            $table->string('banner_image')->nullable(); // Bg image for left side
            
            $table->string('deal_title')->default('HOT DEAL'); // Right Banner Title
            $table->string('discount_value')->nullable(); // 50%
            $table->dateTime('deal_end_date')->nullable(); // Countdown
            $table->string('deal_image_1')->nullable(); // Right side image 1
            $table->string('deal_image_2')->nullable(); // Right side image 2
            
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('flash_deals');
    }
}
