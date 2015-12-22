<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArbitresSportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arbitres_sports', function(Blueprint $table) {
            $table->unsignedInteger('arbitre_id');
            $table->unsignedInteger('sport_id');
            $table->foreign('arbitre_id')
                    ->references('id')
                    ->on('arbitres')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('sport_id')
                    ->references('id')
                    ->on('sports')
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
        Schema::drop('arbitres_sports');
    }
}
