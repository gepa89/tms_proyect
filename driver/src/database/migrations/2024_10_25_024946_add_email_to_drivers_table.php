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
        // Modificar la tabla existente `drivers` para agregar la columna `email`
        Schema::table('drivers', function (Blueprint $table) {
            $table->string('email')->after('license_number');  // Añadir la columna 'email'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar la columna `email` si se revierte la migración
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};

