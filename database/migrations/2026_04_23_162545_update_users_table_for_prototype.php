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
        Schema::table('users', function (Blueprint $table) {
            // Renombrar 'name' a 'nombre'
            $table->renameColumn('name', 'nombre');
        });

        Schema::table('users', function (Blueprint $table) {
            // Añadir campos obligatorios del prototipo
            $table->string('apellido')->nullable()->after('nombre');
            $table->string('telefono', 20)->nullable()->after('email');
            $table->boolean('admin')->default(0)->after('password');
            $table->boolean('confirmado')->default(0);
            $table->string('token', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('nombre', 'name');
            $table->dropColumn(['apellido', 'telefono', 'admin', 'confirmado', 'token']);
        });
    }
};
