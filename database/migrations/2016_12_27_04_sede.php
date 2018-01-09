<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sede extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sede', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collate = 'utf8_spanish_ci';

            $table ->increments('codSede')->unique();
            $table ->string('nombresede')->unique();
            $table ->string('codigosede')->unique();
            $table ->string('direccion')->unique();
            $table ->boolean('estado')->default('1');
        });

        DB::table('sede')->insert(
            array(
                'nombresede' => 'TRUJILLO',
                'codigosede' => 1,
                'direccion' => 'JUAN PABLO II S/N - SAN ANDRES'
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
        Schema::drop('sede');
    }
}
