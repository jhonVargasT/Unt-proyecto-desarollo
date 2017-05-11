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
        Schema::create('facultad', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('idFacultad')->unique();
            $table->string('codFacultad')->unique();
            $table->string('nombre')->unique();
            $table->string('nroCuenta')->unique();
            $table->boolean('estado')->default('1');

            $table->integer('coSede')->unsigned();
            $table->timestamps();
        });

        Schema::table('facultad', function ($table) {

            $table->foreign('coSede')->references('codSede')->on('sede');
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
