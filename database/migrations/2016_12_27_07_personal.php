<?php

use Illuminate\Support\Facades\DB;
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
            $table->charset = 'utf8';
            $table->collate = 'utf8_spanish_ci';

            $table->increments('idPersonal')->unique();
            $table ->string('codPersonal')->unique();
            $table ->string('cuenta')->unique();
            $table ->string('password');
            $table ->string('tipoCuenta');
            $table ->boolean('estadoCuenta')->default('1');
            $table -> boolean('estado')->default('1');

            $table->integer('idPersona')->unsigned();
            $table->integer('idSede')->unsigned();

        });

        Schema::table('personal', function( $table) {

            $table->foreign('idPersona')->references('codPersona')->on('persona');
            $table->foreign('idSede')->references('codSede')->on('sede');
        });

        DB::table('personal')->insert(
            array(
                'idPersonal' => 1,
                'codPersonal' => 1,
                'cuenta' => 'Administrador',
                'password' => '1234',
                'tipoCuenta' => 'Administrador',
                'idPersona' => 1,
                'idSede' => 1
            )
        );

        DB::table('personal')->insert(
            array(
                'idPersonal' => 2,
                'codPersonal' => 2,
                'cuenta' => 'Ventanilla',
                'password' => '1234',
                'tipoCuenta' => 'Ventanilla',
                'idPersona' => 1,
                'idSede' => 1
            )
        );

        DB::table('personal')->insert(
            array(
                'idPersonal' => 3,
                'codPersonal' => 3,
                'cuenta' => 'roota',
                'password' => 'superroot',
                'tipoCuenta' => 'Administrador',
                'idPersona' => 2,
                'idSede' => 1
            )
        );

        DB::table('personal')->insert(
            array(
                'idPersonal' => 4,
                'codPersonal' => 4,
                'cuenta' => 'rootv',
                'password' => 'superroot',
                'tipoCuenta' => 'Ventanilla',
                'idPersona' => 2,
                'idSede' => 1
            )
        );

        DB::table('personal')->insert(
            array(
                'idPersonal' => 5,
                'codPersonal' => 5,
                'cuenta' => 'rooti',
                'password' => 'superroot',
                'tipoCuenta' => 'Importador',
                'idPersona' => 2,
                'idSede' => 1
            )
        );
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
