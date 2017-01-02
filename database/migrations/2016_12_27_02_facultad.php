<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Facultad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('facultad', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table ->increments('idFacultad');
            $table ->string('codFacultad');
            $table ->string('nombre');
            $table ->string('nroCuenta');
            $table -> boolean('estado');
            $table->timestamps();
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
        Schema::drop('facultad');
    }
}
