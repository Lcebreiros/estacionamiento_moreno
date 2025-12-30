<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
