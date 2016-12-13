<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisponibiliteArbitres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disponibilites_arbitres', function($table)
        {
            $table->increments('id');
            $table->unsignedInteger('arbitre_id');
            $table->date('date');
            $table->time('debut');
            $table->time('fin');
            $table->string('commentaire');
            $table->timestamps();

            $table->foreign('arbitre_id')
                ->references('id')
                ->on('arbitres')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('disponibilites_arbitres');
    }
}
