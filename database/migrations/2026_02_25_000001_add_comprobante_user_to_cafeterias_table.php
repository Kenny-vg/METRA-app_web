<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cafeterias', function (Blueprint $table) {
            // Gerente que registró la cafetería
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->after('foto_url');
            // Comprobante de pago subido por el gerente
            $table->string('comprobante_url')->nullable()->after('user_id');
        });

        // Actualizar el enum 'estado' para incluir 'en_revision'
        // SQLite no soporta ALTER COLUMN, por lo que usamos DB::statement para MySQL
        if (config('database.default') !== 'sqlite') {
            \Illuminate\Support\Facades\DB::statement("
                ALTER TABLE cafeterias
                MODIFY COLUMN estado ENUM('activa','suspendida','pendiente','en_revision') NOT NULL DEFAULT 'pendiente'
            ");
        }
    }

    public function down(): void
    {
        Schema::table('cafeterias', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'comprobante_url']);
        });

        if (config('database.default') !== 'sqlite') {
            \Illuminate\Support\Facades\DB::statement("
                ALTER TABLE cafeterias
                MODIFY COLUMN estado ENUM('activa','suspendida','pendiente') NOT NULL DEFAULT 'pendiente'
            ");
        }
    }
};
