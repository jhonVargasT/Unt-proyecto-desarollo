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

            $table ->increments('codDonacion')->unique();
            $table ->string('numResolucion')->unique();
            $table -> date('fechaIngreso');
            $table -> string('descripcion');
            $table->double('monto');
            $table -> boolean('estado')->default('1');

            $table->integer('idTramite')->unsigned();
            $table->integer('idBanco')->unsigned();

        });

        Schema::table('donacion', function( $table) {
            $table->foreign('idTramite')->references('codTramite')->on('tramite');
            $table->foreign('idBanco')->references('codBanco')->on('banco');
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
