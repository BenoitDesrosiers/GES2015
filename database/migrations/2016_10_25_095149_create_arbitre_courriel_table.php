<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArbitreCourrielTable extends Migration
{
    /**
     * Crée les migrations
     *
     * @return void
     */
public function up()
    {
        Schema::create('arbitre_courriel', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('arbitre_id');
            $table->string('courriel');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('arbitre_id')
                    ->references('id')
                    ->on('arbitres')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Défait les migrations
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('arbitre_courriel');
    }
}
