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
        Schema::create('escuela', function ( $table)
        {
            $table->engine = 'InnoDB';
            $table-> integer('idEscuela');
            $table ->string('codEscuela');
            $table ->string('nombre');
            $table ->string('nroCuenta');
            $table -> boolean('estado');
            $table->timestamps();

            $table->integer('codigoFacultad')->unsigned();

        });

        Schema::table('escuela', function(Blueprint $table) {

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
