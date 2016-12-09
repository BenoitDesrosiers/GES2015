<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArbitresTable extends Migration
{
    /**
     * Crée les migrations
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arbitres', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('prenom');
            $table->unsignedInteger('region_id');
            $table->string('numero_accreditation');
            $table->string('association');
            $table->boolean('sexe');
            $table->string('adresse')->nullable();
            $table->date('date_naissance')->nullable();
            $table->timestamps();

            $table->foreign('region_id')
                    ->references('id')
                    ->on('regions')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Défait les migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('arbitres');
    }
}
