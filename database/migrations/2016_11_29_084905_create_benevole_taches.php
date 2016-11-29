<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBenevoleTaches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benevole_taches', function(Blueprint $table) {
            $table->unsignedInteger('benevole_id');
            $table->unsignedInteger('taches_id');
            $table->foreign('benevole_id')
                    ->references('id')
                    ->on('benevoles')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('taches_id')
                    ->references('id')
                    ->on('taches')
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
        Schema::drop('benevole_taches');
    }
}
