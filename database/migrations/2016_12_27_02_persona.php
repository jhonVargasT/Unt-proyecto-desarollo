<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Persona extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('persona', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('codPersona')->unique();
            $table->string('dni')->unique();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('correo')->unique();
            $table->boolean('estado')->default('1');

            //$table->integer('idProduccion')-> unsigned()->nullable();

        });

        /*Schema::table('persona', function ($table) {

            $table->foreign('idProduccion')->references('codProduccion')->on('produccion');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('persona');
    }
}
