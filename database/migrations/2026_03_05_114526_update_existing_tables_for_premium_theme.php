<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update banners table
        if (Schema::hasTable('banners')) {
            Schema::table('banners', function (Blueprint $table) {
                if (!Schema::hasColumn('banners', 'subtitle')) {
                    $table->string('subtitle')->nullable()->after('title');
                }
            });
        }

        // Update about table
        if (Schema::hasTable('about')) {
            Schema::table('about', function (Blueprint $table) {
                if (!Schema::hasColumn('about', 'sub_title')) {
                    $table->string('sub_title')->nullable()->after('title');
                }
                if (!Schema::hasColumn('about', 'promise_title')) {
                    $table->string('promise_title')->nullable();
                }
                if (!Schema::hasColumn('about', 'promise_desc')) {
                    $table->text('promise_desc')->nullable();
                }
                for ($i = 1; $i <= 5; $i++) {
                    if (!Schema::hasColumn('about', "why_choose_{$i}_title")) {
                        $table->string("why_choose_{$i}_title")->nullable();
                    }
                    if (!Schema::hasColumn('about', "why_choose_{$i}_desc")) {
                        $table->text("why_choose_{$i}_desc")->nullable();
                    }
                }
            });
        }

        // Create settings table
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('logo')->nullable();
                $table->string('top_bar_1')->nullable();
                $table->string('top_bar_2')->nullable();
                $table->string('top_bar_3')->nullable();
                $table->string('top_bar_4')->nullable();
                $table->string('footer_desc')->nullable();
                $table->string('facebook')->nullable();
                $table->string('instagram')->nullable();
                $table->string('twitter')->nullable();
                $table->string('youtube')->nullable();
                $table->timestamps();
            });

            // Insert default settings
            DB::table('settings')->insert([
                'logo' => 'premium_assets/images/logo-new.png',
                'top_bar_1' => 'COMFORT IN EVERY MOVE',
                'top_bar_2' => 'LUXURY MADE AFFORDABLE',
                'top_bar_3' => 'FROM TANTEX, FOR YOU',
                'top_bar_4' => 'LEGGINGS THAT FIT YOUR LIFE',
                'facebook' => '#',
                'instagram' => '#',
                'twitter' => '#',
                'youtube' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('subtitle');
        });

        Schema::table('about', function (Blueprint $table) {
            $table->dropColumn(['sub_title', 'promise_title', 'promise_desc']);
            for ($i = 1; $i <= 5; $i++) {
                $table->dropColumn(["why_choose_{$i}_title", "why_choose_{$i}_desc"]);
            }
        });

        Schema::dropIfExists('settings');
    }
};
