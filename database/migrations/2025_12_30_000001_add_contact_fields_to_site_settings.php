<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('site_settings', 'whatsapp_number')) {
                $table->string('whatsapp_number')->nullable()->after('carousel_images');
            }
            if (! Schema::hasColumn('site_settings', 'instagram_url')) {
                $table->string('instagram_url')->nullable()->after('whatsapp_number');
            }
        });

        // Set default values for existing record
        DB::table('site_settings')
            ->whereNull('whatsapp_number')
            ->update([
                'whatsapp_number' => '541123456789',
                'instagram_url' => 'https://instagram.com',
            ]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (Schema::hasColumn('site_settings', 'whatsapp_number')) {
                $table->dropColumn('whatsapp_number');
            }
            if (Schema::hasColumn('site_settings', 'instagram_url')) {
                $table->dropColumn('instagram_url');
            }
        });
    }
};
