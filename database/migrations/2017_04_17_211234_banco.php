<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Banco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('banco', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table -> increments('codBanco')->unique();
            $table -> bigInteger('banco');
            $table -> string('cuenta')->unique();

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
        Schema::drop('banco');
    }
}
