<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Donacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('donacion', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table ->increments('codDonacion');
            $table ->string('numResolucion');
            $table -> date('fechaIngreso');
            $table -> string('decripcion');
            $table -> boolean('estado');
            $table->timestamps();

            $table->integer('idDonacion')->unsigned();
        });

        Schema::table('donacion', function( $table) {

            $table->foreign('idDonacion')->references('codTramite')->on('tramite');
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
        Schema::drop('donacion');
    }
}
