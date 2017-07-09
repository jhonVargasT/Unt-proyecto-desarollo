<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Logerrores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('log_errores_sistema', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table-> increments('idLogErrores')->unique();
            $table->timestamp('fechaRegistro');
            $table->string('mensaje');
            $table->string('funcion');

            $table->integer('coPersonal')->unsigned();
        });

        Schema::table('log_errores_sistema', function($table) {
            $table->foreign('coPersonal')->references('idPersonal')->on('personal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('log_errores_sistema');
    }
}
