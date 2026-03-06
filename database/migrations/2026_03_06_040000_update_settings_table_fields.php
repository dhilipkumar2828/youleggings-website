<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateSettingsTableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Use raw SQL for renaming to avoid dependency on doctrine/dbal or MariaDB version issues with renameColumn
        if (Schema::hasColumn('settings', 'footer_desc')) {
            DB::statement('ALTER TABLE settings CHANGE footer_desc footer_description VARCHAR(255) NULL');
        }
        if (Schema::hasColumn('settings', 'facebook')) {
            DB::statement('ALTER TABLE settings CHANGE facebook facebook_link VARCHAR(255) NULL');
        }
        if (Schema::hasColumn('settings', 'instagram')) {
            DB::statement('ALTER TABLE settings CHANGE instagram instagram_link VARCHAR(255) NULL');
        }
        if (Schema::hasColumn('settings', 'twitter')) {
            DB::statement('ALTER TABLE settings CHANGE twitter twitter_link VARCHAR(255) NULL');
        }
        if (Schema::hasColumn('settings', 'youtube')) {
            DB::statement('ALTER TABLE settings CHANGE youtube youtube_link VARCHAR(255) NULL');
        }

        Schema::table('settings', function (Blueprint $table) {
            // Add missing fields
            if (!Schema::hasColumn('settings', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('settings', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('settings', 'address')) {
                $table->text('address')->nullable();
            }
            if (!Schema::hasColumn('settings', 'google_map')) {
                $table->text('google_map')->nullable();
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
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'footer_description')) {
                DB::statement('ALTER TABLE settings CHANGE footer_description footer_desc VARCHAR(255) NULL');
            }
            if (Schema::hasColumn('settings', 'facebook_link')) {
                DB::statement('ALTER TABLE settings CHANGE facebook_link facebook VARCHAR(255) NULL');
            }
            if (Schema::hasColumn('settings', 'instagram_link')) {
                DB::statement('ALTER TABLE settings CHANGE instagram_link instagram VARCHAR(255) NULL');
            }
            if (Schema::hasColumn('settings', 'twitter_link')) {
                DB::statement('ALTER TABLE settings CHANGE twitter_link twitter VARCHAR(255) NULL');
            }
            if (Schema::hasColumn('settings', 'youtube_link')) {
                DB::statement('ALTER TABLE settings CHANGE youtube_link youtube VARCHAR(255) NULL');
            }
            
            $table->dropColumn(['email', 'phone', 'address', 'google_map']);
        });
    }
}
