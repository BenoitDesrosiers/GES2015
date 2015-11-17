<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TerrainSportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_terrain', function(Blueprint $table) {
            $table->unsignedInteger('terrain_id');
            $table->unsignedInteger('sport_id');
            $table->foreign('terrain_id')
                    ->references('id')
                    ->on('terrains')
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
        Schema::drop('sport_terrain');
    }
}
