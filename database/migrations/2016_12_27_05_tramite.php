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
            $table->charset = 'utf8';
            $table->collate = 'utf8_spanish_ci';

            $table->increments('codTramite')->unique();
            $table->string('clasificador')->unique();
            $table->string('nombre');
            $table->string('fuentefinanc')->nullable();
            $table->char('tipoRecurso')->nullable();
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
