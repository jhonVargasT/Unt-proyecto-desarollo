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
            $table->charset = 'utf8';
            $table->collate = 'utf8_spanish_ci';

            $table-> increments('idAlumno')->unique();
            $table ->string('codAlumno');
            $table -> string('fecha')->nullable();
            $table -> boolean('estado')->default('1');
            $table->integer('idPersona')-> unsigned();
            $table->integer('coEscuela')-> unsigned()->nullable();
            $table->integer('tipoAlumno'); //es para identificar si son de pregrado o postgrado
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
