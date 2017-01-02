<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Personal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('personal', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table ->increments('codPersonal');
            $table ->string('cuenta');
            $table ->string('password');
            $table ->string('tipoCuenta');
            $table ->boolean('estadoCuenta');
            $table -> boolean('estado');
            $table->timestamps();

            $table->integer('idPersona')->unsigned();
        });

        Schema::table('personal', function(Blueprint $table) {

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
        Schema::drop('personal');
    }
}
