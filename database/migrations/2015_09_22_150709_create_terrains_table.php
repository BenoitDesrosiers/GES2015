<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerrainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terrains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('adresse');
            $table->string('description_courte')->nullable();
            $table->unsignedInteger('region_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('terrains');
    }
}
