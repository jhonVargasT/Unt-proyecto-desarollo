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
        Schema::create('subtramite', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table ->increments('codSubtramite');
            $table ->string('cuenta');
            $table ->string('nombre');
            $table ->double('precio');
            $table -> boolean('estado');
            $table->timestamps();

            $table->integer('idTramite')->unsigned();
        });

        Schema::table('subtramite', function(Blueprint $table) {

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
