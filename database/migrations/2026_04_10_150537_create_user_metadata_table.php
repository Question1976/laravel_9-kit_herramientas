<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Extender el modelo 'users'
     * @return void
     */
    public function up()
    {
        Schema::create('user_metadata', function (Blueprint $table) {
            $table->id();
            $table->string('telefono', 50);
            $table->string('direccion');
            // RELACIÓN CON USERS (Uno a Uno)
            // Un usuario tiene un metadata
            // Un metadata pertenece a un usuario
            $table->unsignedBigInteger('users_id');     // FK: guarda el ID del usuario
            // Vincula 'users_id' con 'id' de la tabla 'users'
            // Si se borra el usuario se borra automáticamente su metadata (cascade)
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            // RELACIÓN 2: user_metadata → perfil (Uno a Uno) 
            $table->unsignedBigInteger('perfil_id');    // FK: almacena el ID del perfil
            // Vincula 'perfil_id' con 'id' de la tabla 'perfil'
            // Si se borra el usuario se borra automáticamente su metadata (cascade)
            $table->foreign('perfil_id')->references('id')->on('perfil')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_metadata');
    }
};
