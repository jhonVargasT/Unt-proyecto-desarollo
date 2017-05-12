<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Logunt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('logunt', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table ->increments('codLog')->unique();
            $table ->string('descripcion');
            $table ->dateTime('fecha');
            $table -> boolean('estado')->default('1');

            $table->integer('codigoPersonal')->unsigned();
        });

        Schema::table('logunt', function( $table) {

            $table->foreign('codigoPersonal')->references('idPersonal')->on('personal');
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
        Schema::drop('logunt');
    }
}
