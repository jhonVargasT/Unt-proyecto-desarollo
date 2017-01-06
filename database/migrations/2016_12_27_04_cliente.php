<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cliente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cliente', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table ->increments('codCliente');
            $table ->string('ruc');
            $table -> string('razonSocial');
            $table -> boolean('estado')->default('1');

            $table->integer('idPersona')->unsigned();


        });

        Schema::table('cliente', function( $table) {

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
        Schema::drop('cliente');
    }
}
