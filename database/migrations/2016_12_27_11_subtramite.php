<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Subtramite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('subtramite', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('codSubtramite')->unique();
            $table->string('codigoSubtramite')->unique();
            $table->string('nombre')->unique();
            $table->double('precio');
            $table->boolean('estado')->default('1');
            $table->integer('contador')->default('0');

            $table->integer('idTramite')->unsigned();
        });

        Schema::table('subtramite', function ($table) {

            $table->foreign('idTramite')->references('codTramite')->on('tramite');
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
        Schema::drop('subtramite');
    }
}
