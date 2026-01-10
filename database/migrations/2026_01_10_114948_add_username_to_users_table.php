<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Solo agregar la columna si no existe
        if (!Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->nullable()->after('name');
            });
        }

        // Asignar usernames a usuarios existentes que no tengan username
        $users = \App\Models\User::whereNull('username')->orWhere('username', '')->get();
        foreach ($users as $user) {
            $username = explode('@', $user->email)[0];
            $baseUsername = $username;
            $counter = 1;

            // Asegurar que el username sea único
            while (\App\Models\User::where('username', $username)->where('id', '!=', $user->id)->exists()) {
                $username = $baseUsername . $counter;
                $counter++;
            }

            $user->username = $username;
            $user->save();
        }

        // Verificar si el índice unique ya existe antes de agregarlo
        $indexExists = \DB::select("SHOW INDEX FROM users WHERE Column_name = 'username' AND Non_unique = 0");
        if (empty($indexExists)) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->unique()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
};
