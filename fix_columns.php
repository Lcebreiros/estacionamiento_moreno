<?php

// Script para agregar columnas y tablas faltantes
// Ejecutar con: php fix_columns.php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

echo "=== Verificando y corrigiendo estructura de base de datos ===\n\n";

// 1. Verificar y corregir site_settings
echo "1. Verificando tabla site_settings...\n";

if (!Schema::hasTable('site_settings')) {
    echo "   Creando tabla site_settings...\n";
    Schema::create('site_settings', function (Blueprint $table) {
        $table->id();
        $table->string('primary_color')->default('#eab308');
        $table->string('hero_background_url')->nullable();
        $table->string('logo_url')->nullable();
        $table->json('carousel_images')->nullable();
        $table->string('whatsapp_number')->nullable();
        $table->string('instagram_url')->nullable();
        $table->timestamps();
    });

    DB::table('site_settings')->insert([
        'primary_color' => '#eab308',
        'hero_background_url' => null,
        'logo_url' => null,
        'carousel_images' => json_encode([
            'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?w=800',
            'https://images.unsplash.com/photo-1590674899484-d5640e854abe?w=800',
            'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?w=800',
        ]),
        'whatsapp_number' => '541123456789',
        'instagram_url' => 'https://instagram.com',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "   ✓ Tabla site_settings creada\n";
} else {
    echo "   Verificando columnas...\n";
    Schema::table('site_settings', function (Blueprint $table) {
        if (!Schema::hasColumn('site_settings', 'logo_url')) {
            echo "   Agregando columna logo_url...\n";
            $table->string('logo_url')->nullable();
        }
        if (!Schema::hasColumn('site_settings', 'whatsapp_number')) {
            echo "   Agregando columna whatsapp_number...\n";
            $table->string('whatsapp_number')->nullable();
        }
        if (!Schema::hasColumn('site_settings', 'instagram_url')) {
            echo "   Agregando columna instagram_url...\n";
            $table->string('instagram_url')->nullable();
        }
    });

    DB::table('site_settings')
        ->where(function($q) {
            $q->whereNull('whatsapp_number')->orWhereNull('instagram_url');
        })
        ->update([
            'whatsapp_number' => DB::raw('COALESCE(whatsapp_number, "541123456789")'),
            'instagram_url' => DB::raw('COALESCE(instagram_url, "https://instagram.com")'),
        ]);
    echo "   ✓ Columnas verificadas\n";
}

// 2. Verificar y crear tabla bonificaciones
echo "\n2. Verificando tabla bonificaciones...\n";

if (!Schema::hasTable('bonificaciones')) {
    echo "   Creando tabla bonificaciones...\n";
    Schema::create('bonificaciones', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('logo_url')->nullable();
        $table->string('icon_color')->default('yellow');
        $table->text('icon_svg')->nullable();
        $table->integer('sort_order')->default(0);
        $table->timestamps();
    });
    echo "   ✓ Tabla bonificaciones creada\n";
} else {
    echo "   ✓ Tabla bonificaciones existe\n";
}

echo "\n=== ✓ Base de datos actualizada exitosamente ===\n";
echo "\nAhora ejecuta:\n";
echo "  rm -rf storage/framework/views/*.php\n";
echo "  php artisan view:clear\n";
echo "  php artisan config:clear\n";
echo "  php artisan cache:clear\n";
