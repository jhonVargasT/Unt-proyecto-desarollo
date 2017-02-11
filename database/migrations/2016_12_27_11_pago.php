<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pago extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('pago', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table ->increments('codPago')->unique();
            $table ->string('detalle');
            $table ->dateTime('fecha');
            $table ->double('pago');
            $table -> boolean('estado')->default('1');



            $table->integer('idPersona')->unsigned();
            //$table->integer('idPersonal')->unsigned()->nullable();
            $table->integer('idSubtramite')->unsigned();
        });

        Schema::table('pago', function( $table) {


            $table->foreign('idPersona')->references('codPersona')->on('persona');
            //$table->foreign('idPersonal')->references('codPersonal')->on('personal');
            $table->foreign('idSubtramite')->references('codSubtramite')->on('subtramite');
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
        Schema::drop('pago');
    }
}
