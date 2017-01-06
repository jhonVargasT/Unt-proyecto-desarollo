<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->string('id')->unique();

            $table->integer('idPersonal')->unsigned();

        });

        Schema::table('sessions', function( $table) {

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
        Schema::dropIfExists('sessions');
    }
}
