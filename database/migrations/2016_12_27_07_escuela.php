<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

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

            $table ->increments('codEscuela');
            $table ->string('nombre');
            $table ->string('nroCuenta');
            $table -> boolean('estado');
            $table->timestamps();

            $table->integer('idFacultad')->unsigned();

        });

        Schema::table('escuela', function(Blueprint $table) {

            $table->foreign('idFacultad')->references('codFacultad')->on('facultad');
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
