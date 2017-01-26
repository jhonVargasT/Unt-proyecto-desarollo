<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tramite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tramite', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('codTramite')->unique();
            $table->string('clasificador')->unique();
            $table->string('nombre')->unique();
            $table->string('fuentefinanc');
            $table->char('tipoRecurso');
            $table->boolean('estado')->default('1');
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
        Schema::drop('tramite');
    }
}
