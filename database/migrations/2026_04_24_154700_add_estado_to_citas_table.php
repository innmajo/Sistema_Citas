<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega el campo 'estado' a la tabla de citas
     * para gestionar el ciclo de vida de cada cita
     */
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->string('estado', 20)->default('pendiente')->after('usuarioId');
            // Estados posibles: pendiente, confirmada, cancelada, completada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
