<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactTable extends Migration
{
    /**
     * Exécuter la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function($table)
        {
            $table->increments('id');
            $table->string('prenom');
            $table->string('nom');
            $table->string('telephone');
            $table->string('role');
            $table->unsignedInteger('organisme_id');
            $table->timestamps();

            $table->foreign('organisme_id')
                    ->references('id')
                    ->on('organismes')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Inverser la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contacts');
    }
}
