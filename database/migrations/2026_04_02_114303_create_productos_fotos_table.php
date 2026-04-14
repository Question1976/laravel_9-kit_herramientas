<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_fotos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            // RELACIÓN CON PRODUCTOS (Muchos a Uno)
            // Un producto puede tener muchas fotos
            // Una foto pertenece a un solo producto
            // FK: guarda el ID del producto al que pertenece esta foto
            $table->unsignedBigInteger('productos_id'); 
            // Vincula 'productos_id' con 'id' de la tabla 'productos'
            // Si se borra el producto se borran automáticamente sus fotos (cascade)
            $table->foreign('productos_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_fotos');
    }
};
