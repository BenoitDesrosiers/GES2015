<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableParticipantsEquipes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants_equipes', function(Blueprint $table)
        {
            $table->unsignedInteger('chef_id');
            $table->foreign('chef_id')
                    ->references('id')
                    ->on('participants')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->unsignedInteger('joueur_id');
            $table->foreign('joueur_id')
                    ->references('id')
                    ->on('participants')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

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
        Schema::drop('participants_equipes');
    }
}
