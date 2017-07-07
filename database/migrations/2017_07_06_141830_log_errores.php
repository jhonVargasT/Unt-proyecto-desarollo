<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogErrores extends Migration
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
            $table->integer('idPersonal');
        });

        Schema::table('log_errores_sistema', function($table) {
            $table->foreign('idPersonal')->references('idPersonal')->on('personal');
        });
        //para los erroresasd
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
