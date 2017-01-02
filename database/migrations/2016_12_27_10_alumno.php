<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Alumno extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('alumno', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table ->increments('codAlumno');
            $table ->string('codMatricula');
            $table -> date('fecha');
            $table -> boolean('estado');
            $table->timestamps();

            $table->integer('idPersona')-> unsigned();
            $table->integer('coEscuela')-> unsigned();

        });

        Schema::table('alumno', function($table) {

            $table->foreign('coEscuela')->references('idEscuela')->on('escuela');

            $table->foreign('idPersona')->references('codPersona')->on('persona');

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
        Schema::drop('alumno');
    }
}
