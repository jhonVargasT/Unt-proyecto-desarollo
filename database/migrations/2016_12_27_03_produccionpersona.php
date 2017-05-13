<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Produccionpersona extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('produccionpersona', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('codProduccionPersona')->unique();

            $table->integer('idPersona')->unsigned();
            $table->integer('idProduccion')->unsigned();
        });

        Schema::table('produccionpersona', function( $table) {
            $table->foreign('idProduccion')->references('codProduccion')->on('produccion');
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
        Schema::drop('produccionpersona');
    }
}
