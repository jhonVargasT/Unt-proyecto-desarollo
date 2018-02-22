<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Persona extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('persona', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collate = 'utf8_spanish_ci';

            $table->increments('codPersona')->unique();
            $table->string('dni')->unique();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('correo')->nullable();
            $table->boolean('estado')->default('1');
        });

        DB::table('persona')->insert(
            array(
                'codPersona' => 1,
                'dni' => '',
                'nombres' => 'Monica Soledad',
                'apellidos' => 'Marroquin Gomez',
                'correo' => ''
            )
        );

        DB::table('persona')->insert(
            array(
                'codPersona' => 2,
                'dni' => '',
                'nombres' => 'root',
                'apellidos' => 'root',
                'correo' => ''
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
        Schema::drop('persona');
    }
}
