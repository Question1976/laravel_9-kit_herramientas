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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('slug', 100)->unique();          // URLs únicas: sin repetidos
            $table->text('descripcion');
            $table->date('fecha')->useCurrent();            // Fecha de creación automática (actual)
            $table->bigInteger('precio')->default('0');     // precio inicial: 0
            $table->bigInteger('stock')->default('0');      // saldo inicial: 0
            // RELACIÓN CON CATEGORÍAS (Uno a Muchos)
            // Una categoría tiene muchos productos
            // Un producto pertenece a una categoría
            $table->unsignedBigInteger('categorias_id');    // FK: guarda el ID de la categoría
            // Vincula 'categorias_id' con 'id' de la tabla 'categorias'
            // Si se borra la categoría se borran automáticamente sus productos (cascade)
            $table->foreign('categorias_id')->references('id')->on('categorias')->onDelete('cascade');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
