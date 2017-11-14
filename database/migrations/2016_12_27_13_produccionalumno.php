<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProduccionAlumno extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('produccionalumno', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collate = 'utf8_spanish_ci';

            $table->increments('codProduccionAlumno')->unique();

            $table->integer('codAlumno')->unsigned();
            $table->integer('idProduccion')->unsigned();
        });

        Schema::table('produccionalumno', function( $table) {
            $table->foreign('codAlumno')->references('idAlumno')->on('alumno');
            $table->foreign('idProduccion')->references('codProduccion')->on('produccion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('produccionalumno');
    }
}
