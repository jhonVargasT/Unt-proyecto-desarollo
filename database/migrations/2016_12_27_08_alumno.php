<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('codigoEscuela')-> unsigned();

        });

        Schema::table('alumno', function(Blueprint $table) {

            $table->foreign('idPersona')->references('codPersona')->on('persona');
            $table->foreign('codigoEscuela')->references('idEscuela')->on('escuela');
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
