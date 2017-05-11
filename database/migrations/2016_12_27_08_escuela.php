<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Escuela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('escuela', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table-> increments('idEscuela')->unique();
            $table ->string('codEscuela')->unique();
            $table ->string('nombre')->unique();
            $table ->string('nroCuenta')->unique();
            $table -> boolean('estado')->default('1');

            $table->integer('codigoFacultad')->unsigned();
        });

        Schema::table('escuela', function( $table) {
            $table->foreign('codigoFacultad')->references('idFacultad')->on('facultad');
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
        Schema::drop('escuela');
    }
}
