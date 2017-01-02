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

            $table ->increments('codLog');
            $table ->string('descripcion');
            $table -> boolean('estado');
            $table->timestamps();

            $table->integer('idPersonal')->unsigned();
        });

        Schema::table('logunt', function(Blueprint $table) {

            $table->foreign('idPersonal')->references('codPersonal')->on('personal');
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
