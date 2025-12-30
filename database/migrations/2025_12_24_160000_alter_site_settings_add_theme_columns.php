<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('site_settings')) {
            Schema::create('site_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->nullable();
                $table->json('value')->nullable();
                $table->string('primary_color')->default('#eab308');
                $table->string('hero_background_url')->nullable();
                $table->json('carousel_images')->nullable();
                $table->timestamps();
            });

            return;
        }

        Schema::table('site_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('site_settings', 'primary_color')) {
                $table->string('primary_color')->default('#eab308');
            }
            if (! Schema::hasColumn('site_settings', 'hero_background_url')) {
                $table->string('hero_background_url')->nullable();
            }
            if (! Schema::hasColumn('site_settings', 'carousel_images')) {
                $table->json('carousel_images')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (Schema::hasColumn('site_settings', 'primary_color')) {
                $table->dropColumn('primary_color');
            }
            if (Schema::hasColumn('site_settings', 'hero_background_url')) {
                $table->dropColumn('hero_background_url');
            }
            if (Schema::hasColumn('site_settings', 'carousel_images')) {
                $table->dropColumn('carousel_images');
            }
        });
    }
};
