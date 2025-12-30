<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('site_settings')) {
            Schema::create('site_settings', function (Blueprint $table) {
                $table->id();
                $table->string('primary_color')->default('#eab308');
                $table->string('hero_background_url')->nullable();
                $table->json('carousel_images')->nullable();
                $table->timestamps();
            });
        } else {
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

        // Insert default row if empty
        if (DB::table('site_settings')->count() === 0) {
            DB::table('site_settings')->insert([
                'primary_color' => '#eab308',
                'hero_background_url' => null,
                'carousel_images' => json_encode([
                    'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?w=800',
                    'https://images.unsplash.com/photo-1590674899484-d5640e854abe?w=800',
                    'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?w=800',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // No drop to avoid losing config; leave table intact.
    }
};
