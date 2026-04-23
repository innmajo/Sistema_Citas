<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('producto');
            $table->string('referencia', 100);
            $table->text('description');
            $table->integer('cantidad');
            $table->integer('precio_und');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('productos');
    }
};