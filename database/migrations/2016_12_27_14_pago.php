<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pago extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('pago', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collate = 'utf8_spanish_ci';

            $table->increments('codPago')->unique();
            $table->string('detalle');
            $table->string('fecha');
            $table->string('modalidad');
            $table->boolean('estado')->default('1');
            $table->dateTime('fechaDevolucion')->nullable();
            $table->boolean('estadodeuda')->default('0');
            $table->integer('cantidad');
            $table->string('nroVoucher')->unique()->nullable();
            $table->string('nroCuenta')->nullable();

            $table->integer('idPersona')->unsigned();
            $table->integer('coPersonal')->unsigned()->nullable();
            $table->integer('idSubtramite')->unsigned();
            $table->integer('idProduccionAlumno')->unsigned()->nullable();
        });

        Schema::table('pago', function ($table) {
            $table->foreign('idPersona')->references('codPersona')->on('persona');
            $table->foreign('coPersonal')->references('idPersonal')->on('personal');
            $table->foreign('idSubtramite')->references('codSubtramite')->on('subtramite');
            $table->foreign('idProduccionAlumno')->references('codProduccionAlumno')->on('produccionalumno');
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
        Schema::drop('pago');
    }
}
