<?php

// Script para agregar columnas faltantes a site_settings
// Ejecutar con: php fix_columns.php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

echo "Verificando columnas en site_settings...\n";

Schema::table('site_settings', function (Blueprint $table) {
    if (!Schema::hasColumn('site_settings', 'logo_url')) {
        echo "Agregando columna logo_url...\n";
        $table->string('logo_url')->nullable()->after('hero_background_url');
    }

    if (!Schema::hasColumn('site_settings', 'whatsapp_number')) {
        echo "Agregando columna whatsapp_number...\n";
        $table->string('whatsapp_number')->nullable();
    }

    if (!Schema::hasColumn('site_settings', 'instagram_url')) {
        echo "Agregando columna instagram_url...\n";
        $table->string('instagram_url')->nullable();
    }
});

echo "Actualizando valores por defecto...\n";
DB::table('site_settings')
    ->whereNull('whatsapp_number')
    ->orWhereNull('instagram_url')
    ->update([
        'whatsapp_number' => '541123456789',
        'instagram_url' => 'https://instagram.com',
    ]);

echo "✓ Columnas agregadas exitosamente!\n";
echo "Ahora ejecuta: php artisan config:clear && php artisan cache:clear\n";
