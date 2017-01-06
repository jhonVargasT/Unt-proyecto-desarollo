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
        Schema::create('tramite', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table ->increments('codTramite');
            $table ->string('clasificador');
            $table ->string('nombre');
            $table ->string('fuentefinanc');
            $table ->boolean('tipoRecurso');
            $table -> boolean('estado');

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
